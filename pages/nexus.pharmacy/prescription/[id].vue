<template>
  <HbPage layout-name="pharmacylayout" section-name="Nexus Pharmacy" :title="pageId==='create'?`Create a prescription ${patientName? `(${patientName})`:''}`:`Modify prescription ${patientName? `- ${patientName}`:''}`" section-svg-icon='<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 26 26"><!-- Icon from Pepicons Pencil by CyCraft - https://github.com/CyCraft/pepicons/blob/dev/LICENSE --><g fill="currentColor"><path fill-rule="evenodd" d="m18.85 13.192l-6.365-6.364a4 4 0 0 0-5.657 5.657l6.364 6.364a4 4 0 1 0 5.657-5.657M7.535 7.536a3 3 0 0 1 4.242 0l6.364 6.364a3 3 0 1 1-4.242 4.242l-6.364-6.364a3 3 0 0 1 0-4.242" clip-rule="evenodd"/><path d="m16.037 10.58l-.243.97c-1.201-.3-2.223-.154-3.101.432c-.87.58-1.454 1.687-1.73 3.355l-.987-.164c.318-1.917 1.032-3.27 2.162-4.023c1.122-.748 2.434-.936 3.899-.57"/><path fill-rule="evenodd" d="M13 24.5c6.351 0 11.5-5.149 11.5-11.5S19.351 1.5 13 1.5S1.5 6.649 1.5 13S6.649 24.5 13 24.5m0 1c6.904 0 12.5-5.596 12.5-12.5S19.904.5 13 .5S.5 6.096.5 13S6.096 25.5 13 25.5" clip-rule="evenodd"/></g></svg>'>

    <div class="card p-4">
      <h5 class="mb-4">Prescription Information</h5>

      <div class="mb-3">
         <p><strong>Donor Name :</strong> {{ patientName??"Unknown Patient" }}</p>
        <p><strong>Reference :</strong> {{ patientRef }}</p>
      </div>

      <div class="row g-2 mb-3 align-items-end"  v-if="!readOnly">
        <div class="col-md-4">
          <label class="form-label"><Translate text="Choose item"/>:</label>
<!--          <multiselect required v-model="selection.item" :options="services" label="name" track-by="uniqid" searchable></multiselect>-->

        </div>
        <div class="col-md-4" v-if="selection.item && selection.item.has_more_selection ">
          <label class="form-label">&nbsp;</label>
          <multiselect required v-model="selection.selected" :options="subitems" label="name" track-by="uniqid" searchable></multiselect>
        </div>
        <div class="col-md-4" v-if="selection.selected">
          <label class="form-label">&nbsp;</label>
          <button class="btn btn-primary w-100"  @click="constituents.push(selection.selected);selection.selected=null;">Add item</button>
        </div>
      </div>

      <hr/>

      <table class="table" v-if="constituents">
        <thead>
        <tr>
          <th><Translate text="Items"/></th>
          <th><Translate text="Prescription"/></th>
          <th><Translate text="Quantity"/></th>
          <th><Translate text="Unit Price"/> ({{getAppConfig("currency")}})</th>
          <th><Translate text="Reduction"/></th>
          <th><Translate text="Total"/> ({{getAppConfig("currency")}})</th>
          <th></th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(consty,index) in constituents">

          <td>
            <p style="margin-bottom: 0px;">{{consty.name}}</p>
            <small v-if="consty.subname" style="opacity: 0.5">{{consty.subname}}</small>
          </td>
          <td>
            <textarea type="number" class="form-control" v-if="!readOnly" v-model="consty.description" :disabled="readOnly"></textarea>

            <span v-else>{{consty.description}}</span>
          </td>
          <td>
            <div style="display: flex;justify-content: center;align-items: center;">
              <input type="number" class="form-control" v-if="consty.quantifiable&&!readOnly" v-model="consty.quantity" :disabled="readOnly" style="max-width:60px;"/>

              <span v-else-if="consty.quantifiable">{{consty.quantity??1}}</span>

              <span v-if="consty.quantifiable && consty.quantity_unit" style="margin-left: 10px;">({{consty.quantity_unit}})</span>

            </div>
          </td>
          <td>
            <input type="number" class="form-control"  v-model="consty.unit_price" v-if="!readOnly" :disabled="readOnly" style="max-width:160px;" />
            <span v-else>{{consty.unit_price??0}}</span>

          </td>
          <td >
            <div class="d-flex">
              <select class="form-select me-2" v-model="consty.reduction_rate" :disabled="readOnly" v-if="!readOnly">
                <option value="flat">Flat</option>
                <option value="percentage">Percentage</option>
              </select>

              <input type="number" class="form-control"  v-model="consty.reduction" :disabled="readOnly" v-if="!readOnly"/>

              <span v-else>{{consty.reduction??0}} (<Translate :text="`${consty.reduction_rate??'flat'}`"/>)</span>
            </div>
          </td>
          <td>{{calculateConstituentTotal(consty)}}</td>
          <td>
            <svg v-if="!readOnly" @click="removeConstAt(index)" style="color: red" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M5 19q-.825 0-1.412-.587T3 17V8q-.425 0-.712-.288T2 7t.288-.712T3 6h3v-.5q0-.425.288-.712T7 4.5h2q.425 0 .713.288T10 5.5V6h3q.425 0 .713.288T14 7t-.288.713T13 8v9q0 .825-.587 1.413T11 19zm11-1q-.425 0-.712-.288T15 17t.288-.712T16 16h2q.425 0 .713.288T19 17t-.288.713T18 18zm0-4q-.425 0-.712-.288T15 13t.288-.712T16 12h4q.425 0 .713.288T21 13t-.288.713T20 14zm0-4q-.425 0-.712-.288T15 9t.288-.712T16 8h5q.425 0 .713.288T22 9t-.288.713T21 10z"/></svg>
          </td>
        </tr>
        <tr>
          <td colspan="5"><strong>Total:</strong> </td>
          <td  style="font-size: 14px"> {{ calculateTotalCost }} {{getAppConfig("currency")}}</td>
          <td>
          </td>
        </tr>
        </tbody>
      </table>

      <div class="text-end mb-3">

      </div>
      <div v-if="!readOnly" style="align-items: center; display: flex">
        <p style="margin-right: 10px;margin-top:5px;"><strong><Translate text="State"/></strong></p>
        <select v-model="billStatus" class="form-control" style="max-width: 200px;">
          <option value="PAID"><Translate text="PAID"/> </option>
          <option value="PENDING"><Translate text="PENDING"/></option>
          <option value="CANCELLED"><Translate text="CANCELLED"/></option>
        </select>
      </div>

      <div class="text-end" v-if="!readOnly">
        <button class="btn btn-primary" @click="createPrescription"><Translate text="Submit"/></button>
      </div>
    </div>
  </HbPage>
</template>
<script>
import {computed, ref, watch} from 'vue';

export default {
  setup(props, { expose }) {
    const selection = ref({
      item: null,
      subitem: null,
      selected: null,
    });

    const subitems = ref([]);
    const services = ref([]);
    const constituents = ref([]);

    // Load subitems when main item changes
    watch(() => selection.value.item, (newItem) => {
      selection.value.selected = null;

      if (newItem && newItem.has_more_selection) {
        getRequestLoad_(
            `/nx/nexus-bill-subitems/${newItem.uniqid}`,
            {
              "patient":`${getQueryParameter("uid")??window.currentPatientId}`
            },
            (x) => {
              subitems.value = x;
            },
            (x) => {},
            () => {},
            "subitemsselectionsmenuloader"
        );
      } else if (newItem) {
        selection.value.selected = {
          name: newItem.name,
          subname: null,
          nexus_bill_service_ref: newItem.uniqid,
          quantity: 1,
          unit_price: newItem.unit_price ?? 0,
          subtotal: newItem.unit_price ?? 0,
          total: newItem.unit_price ?? 0,
          reduction: 0,
          reduction_rate: 'flat',
          quantifiable: newItem.quantifiable,
          parent:newItem.uniqid,
          quantity_unit:newItem.quantity_unit,
        };
        subitems.value = [];
      }
    });


    // Calculate subtotal for one constituent (as a method)
    const calculateConstituentSubTotal = (consty) => {
      const quantity = consty.quantity ?? 1;
      const unit_price = consty.unit_price ?? 0;
      return quantity * unit_price;
    };


    // Calculate total for one constituent (as a method)
    const calculateConstituentTotal = (consty) => {
      const quantity = consty.quantity ?? 1;
      const unit_price = consty.unit_price ?? 0;
      const amount = quantity * unit_price;

      let reduction = 0;
      if (consty.reduction_rate === 'percentage') {
        reduction = amount * ((consty.reduction ?? 0) / 100);
      } else {
        reduction = consty.reduction ?? 0;
      }

      return amount - reduction;
    };

    const calculateConstituentReduction = (consty) => {
      const quantity = consty.quantity ?? 1;
      const unit_price = consty.unit_price ?? 0;
      const amount = quantity * unit_price;

      let reduction = 0;
      if (consty.reduction_rate === 'percentage') {
        reduction = amount * ((consty.reduction ?? 0) / 100);
      } else {
        reduction = consty.reduction ?? 0;
      }

      return reduction;
    };


    // Reactive total cost computed
    const calculateTotalCost = computed(() => {
      return constituents.value.reduce((total, consty) => {
        return total + calculateConstituentTotal(consty);
      }, 0);
    });



    // Reactive total reduction computed
    const calculateTotalReduction = computed(() => {
      return constituents.value.reduce((total, consty) => {
        return total + calculateConstituentReduction(consty);
      }, 0);
    });


    return {
      selection,
      subitems,
      services,
      constituents,
      calculateConstituentTotal,
      calculateTotalCost,
      calculateTotalReduction,
      calculateConstituentReduction,
      calculateConstituentSubTotal
    };
  },

  mounted() {
    // if (!this.patientId && this.pageId==='create') {
    //   return this.$router.push('/nexus.pharmacy/prescriptions');
    // }
    this.loadData();
  },

  data() {
    const route = useRoute();
    window.currentPatientId= getQueryParameter("uid")
    return {
      patientName: getQueryParameter("name"),
      patientRef: getQueryParameter("ref"),
      patientId: window.currentPatientId,
      readOnly: getQueryParameter("ro") ?? false,
      pageId:route.params.id,
      statuses:[
          "PENDING",
          "PAID",
          "CANCELED",
      ],
      billStatus:"PENDING"
    };
  },

  methods: {
    removeConstAt(index){
      if(confirm('Are you sure?')){
        this.constituents.splice(index,1)
      }
    },
    loadData() {
      getRequestLoad_(
          "/nx/nexus-bill-creation-data",
          {
            pageId: this.pageId,
            patientId:this.patientId,
            type:"PRESCRIPTION",
          },
          (x) => {
            this.services = x.services;
            this.selection.item = this.services[0]
            if(x.patient){
              this.patientName = x.patient.name;
              this.patientRef = x.patient.reference;
              this.patientId = x.patient.uniqid;
              window.currentPatientId=this.patientId;
            }
            if(x.bill_constituents){
              this.constituents=x.bill_constituents;
            }
            if(x.bill){
              this.billStatus = x.bill.status??"PENDING"
            }

          }
      );
    },

    createPrescription() {
      const bill_items = this.constituents.map(item => {
        return {
          nexus_bill_service_ref:item.nexus_bill_service_ref,

          quantity: item.quantity??1,
          unit_price: item.unit_price ?? 0,
          subtotal: this.calculateConstituentSubTotal(item),
          reduction:item.reduction,
          reduction_rate:item.reduction_rate,
          reduction_calculated_value: this.calculateConstituentReduction(item),
          total: this.calculateConstituentTotal(item),

          name: item.name,
          subname: item.subname,


          description:item.description,

          meta:{
            "item":item.parent
          },
          // id:item.id
        }
      });

      const bill = {
        patient_ref:this.patientId,
        amount:this.calculateTotalCost,
        reduction:this.calculateTotalReduction,
        currency:getAppConfig("currency"),
        status:this.billStatus,
        type:"PRESCRIPTION"
      }

      if(this.pageId==="create"){
        postRequestLoad_('/nx/nexus-bill-create',{
          bill,
          constituents: bill_items,
        },(x)=>{
          successToast(this.$t("Created Successfully"));
          this.$router.push("/nexus.pharmacy/prescription/"+x.bill.uniqid);
        })
      }else{
        console.log({
          bill,
          constituents: bill_items,
        })

        postRequestLoad_('/nx/nexus-bill-edit/'+this.pageId,{
          bill,
          constituents: bill_items,
        },(x)=>{
          successToast(this.$t("Updated Successfully"));
        })
      }

    }
  },
};
</script>
