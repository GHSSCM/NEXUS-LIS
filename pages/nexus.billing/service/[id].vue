<template>
  <HbPage layout-name="billinglayout" section-name="Nexus Billing" :title="pageId!=='create'?`Edit service ${service.name?`(${service.name})`:''}`:'Create a service'" section-svg-icon='<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><!-- Icon from Stash Icons by Pingback LLC - https://github.com/stash-ui/icons/blob/master/LICENSE --><path fill="currentColor" d="M7.179 3.5h5.642c.542 0 .98 0 1.333.029c.365.03.685.093.981.243a2.5 2.5 0 0 1 1.092 1.093c.151.296.214.616.244.98c.029.355.029.792.029 1.334v3.071a.5.5 0 0 1-1 0V7.2c0-.568 0-.964-.026-1.273c-.024-.302-.07-.476-.138-.608a1.5 1.5 0 0 0-.655-.656c-.132-.067-.305-.113-.608-.137c-.309-.026-.705-.026-1.273-.026H7.2c-.568 0-.964 0-1.273.026c-.302.024-.476.07-.608.137a1.5 1.5 0 0 0-.656.656c-.067.132-.113.306-.137.608C4.5 6.236 4.5 6.632 4.5 7.2v9.6c0 .568 0 .965.026 1.273c.024.302.07.476.137.608a1.5 1.5 0 0 0 .646.65l.01.002c.018.004.062.014.144.026q.189.028.495.05c.404.03.92.05 1.466.064c1.089.027 2.265.027 2.826.027a.5.5 0 0 1 0 1h-.001c-.56 0-1.748 0-2.85-.027a33 33 0 0 1-1.515-.066a8 8 0 0 1-.566-.058a1.5 1.5 0 0 1-.453-.122a2.5 2.5 0 0 1-1.093-1.092c-.15-.296-.213-.616-.243-.98C3.5 17.8 3.5 17.362 3.5 16.82V7.18c0-.542 0-.98.029-1.333c.03-.365.093-.685.243-.981a2.5 2.5 0 0 1 1.093-1.093c.296-.15.616-.213.98-.243c.355-.03.793-.03 1.335-.03"/><path fill="currentColor" d="M18.62 12.5c.403 0 .735 0 1.006.022c.281.023.54.072.782.196a2 2 0 0 1 .874.874c.124.243.173.501.196.782c.022.27.022.603.022 1.005v2.242c0 .402 0 .734-.022 1.005c-.023.281-.072.54-.196.782a2 2 0 0 1-.874.874c-.243.124-.501.173-.782.196c-.27.022-.603.022-1.005.022h-4.242c-.402 0-.734 0-1.005-.022c-.281-.023-.54-.072-.782-.196a2 2 0 0 1-.874-.874c-.124-.243-.173-.501-.196-.782c-.022-.27-.022-.603-.022-1.005v-2.242c0-.402 0-.734.022-1.005c.023-.281.072-.54.196-.782a2 2 0 0 1 .874-.874c.243-.124.501-.173.782-.196c.27-.022.603-.022 1.005-.022zm-5.164 1.019c-.22.018-.332.05-.41.09a1 1 0 0 0-.437.437c-.04.078-.072.19-.09.41l-.004.044h7.97l-.004-.044c-.018-.22-.05-.332-.09-.41a1 1 0 0 0-.437-.437c-.078-.04-.19-.072-.41-.09a13 13 0 0 0-.944-.019h-4.2c-.428 0-.72 0-.944.019M20.5 16.5h-8v1.1c0 .428 0 .72.019.944c.018.22.05.332.09.41a1 1 0 0 0 .437.437c.078.04.19.072.41.09c.225.019.516.019.944.019h4.2c.428 0 .72 0 .944-.019c.22-.018.332-.05.41-.09a1 1 0 0 0 .437-.437c.04-.078.072-.19.09-.41c.019-.225.019-.516.019-.944zm-14-10a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zM6 10a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 6 10m.5 2.5a.5.5 0 0 0 0 1H10a.5.5 0 0 0 0-1zM6 17a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 6 17"/></svg>'>
    <div>

      <form @submit.prevent="save">
        <div class="row">

          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Service Name * "/>
              </label>
              <input v-model="service.name" required class="form-control" type="text" :placeholder="$t('Enter The Service Name')"/>
            </div>
          </div>



          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Service Description"/>
              </label>
              <textarea cols="7" v-model="service.description" class="form-control"  :placeholder="$t('Enter The Service Description')"/>
            </div>
          </div>




          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Is the service quantifiable?"/>
              </label>

              <select v-model="quantifiable_text" required class="form-control">
                <option >-- Select an option ---</option>
                <option value="YES">YES </option>
                <option value="NO">NO </option>
              </select>
            </div>
          </div>




          <div class="col-sm-12 col-md-6" v-if="quantifiable_text==='YES'">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Quantity Unit"/>
              </label>

              <input v-model="service.quantity_unit"  required class="form-control" type="number" :placeholder="$t('Enter the unit')"/>
            </div>
          </div>





          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Unit price"/> ({{getAppConfig("currency")}})
              </label>

              <input v-model="service.unit_price"  required class="form-control" type="text" :placeholder="$t('Enter the unit price')"/>
            </div>
          </div>



          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="State"/>
              </label>

              <select v-model="service.state" required class="form-control">
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
    forceOutPermissionVerify(Permission.BILLING_MANAGE_SERVICES,this)
  },
  data(){
    const route = useRoute()
    return {
      pageId:route.params.id,
      service:{

      },
      fields:[
      ],
      quantifiable_text:"NO"
    }
  },
  mounted(){
    const context=this;
    if(this.pageId!=='create'){
      getRequestLoad_('/nx/nexus-bill-services/'+this.pageId,{},(u)=>{
        this.service=u;
        this.quantifiable_text =this.service.quantifiable?"YES":"NO"
      },()=>{
        alert("Connection error. Please refresh and try again.")
      })
    }else{

    }
  },
  methods:{
    save(){
      const context=this;
      this.service.quantifiable = this.quantifiable_text==="YES";
      if(this.pageId==="create"){
        postRequestLoad_('/nx/nexus-bill-services/',this.service,(fields)=>{
          context.$router.push('/nexus.billing/services')
          successToast(this.$t("Service created successfully"))
        })
      }else{
        postRequestLoad_('/nx/nexus-bill-services/'+this.pageId,this.service,(fields)=>{
          // context.$router.push('/accounts')
          successToast(this.$t("Service updated successfully"))
        },()=>{
          // alert("Connection error. Please refresh and try again.")
        })
      }
    }
  }
}
</script>