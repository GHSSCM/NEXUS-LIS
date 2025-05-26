<template>
  <HbPage layoutName="pharmacylayout"  sectionSvgIcon='<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 26 26"><!-- Icon from Pepicons Pencil by CyCraft - https://github.com/CyCraft/pepicons/blob/dev/LICENSE --><g fill="currentColor"><path fill-rule="evenodd" d="m18.85 13.192l-6.365-6.364a4 4 0 0 0-5.657 5.657l6.364 6.364a4 4 0 1 0 5.657-5.657M7.535 7.536a3 3 0 0 1 4.242 0l6.364 6.364a3 3 0 1 1-4.242 4.242l-6.364-6.364a3 3 0 0 1 0-4.242" clip-rule="evenodd"/><path d="m16.037 10.58l-.243.97c-1.201-.3-2.223-.154-3.101.432c-.87.58-1.454 1.687-1.73 3.355l-.987-.164c.318-1.917 1.032-3.27 2.162-4.023c1.122-.748 2.434-.936 3.899-.57"/><path fill-rule="evenodd" d="M13 24.5c6.351 0 11.5-5.149 11.5-11.5S19.351 1.5 13 1.5S1.5 6.649 1.5 13S6.649 24.5 13 24.5m0 1c6.904 0 12.5-5.596 12.5-12.5S19.904.5 13 .5S.5 6.096.5 13S6.096 25.5 13 25.5" clip-rule="evenodd"/></g></svg>' sectionName="Nexus Pharmacy" :title="pageId==='create'?`Add new drug`:`Edit Drug ${drug.name?`(${drug.name})`:''}`"  >
    <div>

      <form @submit.prevent="save">
        <div class="row">

          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Drug Name * "/>
              </label>
              <input v-model="drug.name" required class="form-control" type="text" :placeholder="$t('Enter The Service Name')"/>
            </div>
          </div>


          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Drug Code "/>
              </label>
              <input v-model="drug.code"  class="form-control" type="text" :placeholder="$t('Enter The Drug Code')"/>
            </div>
          </div>

          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Drug Description"/>
              </label>
              <textarea cols="7" v-model="drug.description" class="form-control"  :placeholder="$t('Enter The Drug Description')"/>
            </div>
          </div>





          <div class="col-sm-12 col-md-6" >
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Unit"/>
              </label>

              <input v-model="drug.unit"   class="form-control" type="text" :placeholder="$t('Enter the unit')"/>
            </div>
          </div>


          <div class="col-sm-12 col-md-6" >
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Initial Quantity"/>
              </label>

              <input v-model="drug.quantity"   class="form-control" type="number" :placeholder="$t('Enter the quantity')"/>
            </div>
          </div>



          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Unit price"/> ({{getAppConfig("currency")}})
              </label>

              <input v-model="drug.unit_price"   class="form-control" type="number" :placeholder="$t('Enter the unit price')"/>
            </div>
          </div>



          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Drug Type"/>
              </label>

              <select v-model="drug.type" required class="form-control">
<!--                <option >&#45;&#45; Select an option -&#45;&#45;</option>-->
                <option value="CAPSULE">Capsule </option>
                <option value="INJECTABLE">Injectable </option>
                <option value="INHALER">Inhaler </option>
                <option value="LIQUID">Liquid </option>
                <option value="DRIP">Drip </option>
                <option value="OTHER">Other </option>
              </select>

            </div>
          </div>



          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="State"/>
              </label>

              <select v-model="drug.state" required class="form-control">
                <option >-- Select a state ---</option>
                <option value="ACTIVE">ACTIVE </option>
                <option value="INACTIVE">INACTIVE </option>
              </select>

            </div>
          </div>


        </div>

        <br/>
        <br/>
        <button class="btn btn-primary w-100" style="border:0">
          + <Translate text="Save"/>
        </button>
        <br/>
      </form>

    </div>
  </HbPage>
</template>


<script>
export default{
  setup(){
    forceOutPermissionVerify(Permission.PHARMACY_MANAGE_DRUG,this)
  },
  data(){
    const route = useRoute()
    return {
      pageId:route.params.id,
      drug:{
          "type":"other"
      },
      fields:[
      ],

    }
  },
  mounted(){
    const context=this;
    if(this.pageId!=='create'){
      getRequestLoad_('/nx/drugs/'+this.pageId,{},(u)=>{
        this.drug=u;
      },()=>{
        alert("Connection error. Please refresh and try again.")
      })
    }else{

    }
  },
  methods:{
    save(){
      const context=this;
      if(this.pageId==="create"){
        postRequestLoad_('/nx/drugs/',this.drug,(fields)=>{
          context.$router.push('/nexus.pharmacy/drugs')
          successToast(this.$t("Drug created successfully"))
        })
      }else{
        postRequestLoad_('/nx/drugs/'+this.pageId,this.drug,(fields)=>{
          successToast(this.$t("Drug updated successfully"))
        },()=>{
        })
      }
    }
  }
}
</script>