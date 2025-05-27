<template>
  <HbPage layout-name="billinglayout" section-name="Nexus Billing" :title="`Create a bill ${patientName? `(${patientName})`:''}`" section-svg-icon='<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><!-- Icon from Stash Icons by Pingback LLC - https://github.com/stash-ui/icons/blob/master/LICENSE --><path fill="currentColor" d="M7.179 3.5h5.642c.542 0 .98 0 1.333.029c.365.03.685.093.981.243a2.5 2.5 0 0 1 1.092 1.093c.151.296.214.616.244.98c.029.355.029.792.029 1.334v3.071a.5.5 0 0 1-1 0V7.2c0-.568 0-.964-.026-1.273c-.024-.302-.07-.476-.138-.608a1.5 1.5 0 0 0-.655-.656c-.132-.067-.305-.113-.608-.137c-.309-.026-.705-.026-1.273-.026H7.2c-.568 0-.964 0-1.273.026c-.302.024-.476.07-.608.137a1.5 1.5 0 0 0-.656.656c-.067.132-.113.306-.137.608C4.5 6.236 4.5 6.632 4.5 7.2v9.6c0 .568 0 .965.026 1.273c.024.302.07.476.137.608a1.5 1.5 0 0 0 .646.65l.01.002c.018.004.062.014.144.026q.189.028.495.05c.404.03.92.05 1.466.064c1.089.027 2.265.027 2.826.027a.5.5 0 0 1 0 1h-.001c-.56 0-1.748 0-2.85-.027a33 33 0 0 1-1.515-.066a8 8 0 0 1-.566-.058a1.5 1.5 0 0 1-.453-.122a2.5 2.5 0 0 1-1.093-1.092c-.15-.296-.213-.616-.243-.98C3.5 17.8 3.5 17.362 3.5 16.82V7.18c0-.542 0-.98.029-1.333c.03-.365.093-.685.243-.981a2.5 2.5 0 0 1 1.093-1.093c.296-.15.616-.213.98-.243c.355-.03.793-.03 1.335-.03"/><path fill="currentColor" d="M18.62 12.5c.403 0 .735 0 1.006.022c.281.023.54.072.782.196a2 2 0 0 1 .874.874c.124.243.173.501.196.782c.022.27.022.603.022 1.005v2.242c0 .402 0 .734-.022 1.005c-.023.281-.072.54-.196.782a2 2 0 0 1-.874.874c-.243.124-.501.173-.782.196c-.27.022-.603.022-1.005.022h-4.242c-.402 0-.734 0-1.005-.022c-.281-.023-.54-.072-.782-.196a2 2 0 0 1-.874-.874c-.124-.243-.173-.501-.196-.782c-.022-.27-.022-.603-.022-1.005v-2.242c0-.402 0-.734.022-1.005c.023-.281.072-.54.196-.782a2 2 0 0 1 .874-.874c.243-.124.501-.173.782-.196c.27-.022.603-.022 1.005-.022zm-5.164 1.019c-.22.018-.332.05-.41.09a1 1 0 0 0-.437.437c-.04.078-.072.19-.09.41l-.004.044h7.97l-.004-.044c-.018-.22-.05-.332-.09-.41a1 1 0 0 0-.437-.437c-.078-.04-.19-.072-.41-.09a13 13 0 0 0-.944-.019h-4.2c-.428 0-.72 0-.944.019M20.5 16.5h-8v1.1c0 .428 0 .72.019.944c.018.22.05.332.09.41a1 1 0 0 0 .437.437c.078.04.19.072.41.09c.225.019.516.019.944.019h4.2c.428 0 .72 0 .944-.019c.22-.018.332-.05.41-.09a1 1 0 0 0 .437-.437c.04-.078.072-.19.09-.41c.019-.225.019-.516.019-.944zm-14-10a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zM6 10a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 6 10m.5 2.5a.5.5 0 0 0 0 1H10a.5.5 0 0 0 0-1zM6 17a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 6 17"/></svg>'>

    <div class="card p-4">
      <h5 class="mb-4">Billing Information</h5>

      <div class="mb-3">
        <p><strong>Patient Name :</strong> {{ patientName }}</p>
        <p><strong>Reference :</strong> {{ patientRef }}</p>
      </div>

      <div class="row g-2 mb-3 align-items-end"  v-if="!readOnly">
        <div class="col-md-4">
          <label class="form-label"><Translate text="Choose item"/>:</label>
          <multiselect required v-model="selection.item" :options="services" label="name" track-by="uniqid" searchable></multiselect>

        </div>
        <div class="col-md-4" v-if="selection.item && selection.item.has_more_selection ">
<!--          && subitems.length>0-->
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
          <th><Translate text="Quantity"/></th>
          <th><Translate text="Unit Price"/> ({{getAppConfig("currency")}})</th>
          <th><Translate text="Reduction"/></th>
          <th><Translate text="Total"/> ({{getAppConfig("currency")}})</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="consty in constituents">
          <td>
            <p style="margin-bottom: 0px;">{{consty.name}}</p>
            <small v-if="consty.subname" style="opacity: 0.5">{{consty.subname}}</small>
          </td>
          <td><input type="number" class="form-control" v-if="consty.quantifiable" v-model="consty.quantity" :disabled="readOnly" style="max-width:60px;"/></td>
          <td><input type="number" class="form-control"  v-model="consty.unit_price" :disabled="readOnly" style="max-width:160px;" /></td>
          <td class="d-flex">
            <select class="form-select me-2" v-model="consty.reduction_rate" :disabled="readOnly">
              <option value="flat">Flat</option>
              <option value="percentage">Percentage</option>
            </select>

            <input type="number" class="form-control"  v-model="consty.reduction" :disabled="readOnly" />

          </td>
          <td>{{calculateConstituentTotal(consty)}}</td>
        </tr>
        <tr>
          <td colspan="4"><strong>Total:</strong> </td>
          <td  style="font-size: 14px"> {{ calculateTotalCost }} {{getAppConfig("currency")}}</td>
        </tr>
        </tbody>
      </table>

      <div class="text-end mb-3">

      </div>

      <div class="text-end">
        <button class="btn btn-primary">Submit</button>
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
              "patient":`${getQueryParameter("uid")}`
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
      calculateConstituentReduction,
      calculateConstituentSubTotal
    };
  },

  mounted() {
    if (!this.patientId) {
      return this.$router.back();
    }
    this.loadData();
  },

  data() {
    return {
      patientName: getQueryParameter("name"),
      patientRef: getQueryParameter("ref"),
      patientId: getQueryParameter("uid"),
      readOnly: getQueryParameter("ro") ?? false,
    };
  },

  methods: {
    loadData() {
      getRequestLoad_(
          "/nx/nexus-bill-creation-data",
          {},
          (x) => {
            this.services = x.services;
          }
      );
    },

    createBilling() {
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
          subname: item.subname
        }
      });
    }
  },
};
</script>
