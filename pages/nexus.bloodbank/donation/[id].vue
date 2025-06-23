<template>
  <HbPage layoutName="bloodbanklayout"
          sectionSvgIcon='<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48"><!-- Icon from Health Icons by Resolve to Save Lives - https://github.com/resolvetosavelives/healthicons/blob/main/LICENSE --><g fill="currentColor"><path d="M15.465 31.398a1 1 0 1 0-1.902.62a11.53 11.53 0 0 0 4.178 5.767a11.48 11.48 0 0 0 6.759 2.203c.552 0 1-.449 1-1.003s-.448-1.003-1-1.003a9.5 9.5 0 0 1-5.584-1.82a9.53 9.53 0 0 1-3.451-4.764"/><path fill-rule="evenodd" d="m24 4l-.69.66l-.004.004l-.009.008l-.032.032l-.122.119q-.16.157-.456.455a72 72 0 0 0-6.492 7.621C12.681 17.68 9 24.082 9 30.08C9 37.845 15.796 44 24 44s15-6.155 15-13.92c0-6-3.681-12.401-7.195-17.18a72 72 0 0 0-6.492-7.622a42 42 0 0 0-.578-.574l-.032-.032l-.01-.008zm-1.451 4.334A64 64 0 0 1 24 6.8a70 70 0 0 1 6.195 7.29C33.681 18.832 37 24.777 37 30.08c0 6.503-5.74 11.914-13 11.914S11 36.583 11 30.08c0-5.303 3.319-11.248 6.805-15.99a70 70 0 0 1 4.744-5.756" clip-rule="evenodd"/></g></svg>'
          sectionName="Nexus Blood Bank" :title="pageId==='create'?`Register donation`:`Edit Donation`"  >
    <div>

      <div class="mb-3">
        <p><strong>Donor Name :</strong> {{ patientName??"Unknown Donor" }}</p>
        <p><strong>Reference :</strong> {{ patientRef }}</p>
      </div>

      <form @submit.prevent="save">
        <div class="row">

          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Quantity (in ml) * "/>
              </label>
              <input v-model="donation.quantity" required class="form-control" type="number" :placeholder="$t('Enter The Quantity')"/>
            </div>
          </div>


          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Donation Date/Time "/>
              </label>
              <input v-model="donation.donated_at"  class="form-control" type="datetime-local"/>
            </div>
          </div>


          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Extra Details (Vital Signs, Test Results, etc)"/>
              </label>
              <textarea cols="7" v-model="donation.details" class="form-control"  :placeholder="$t('Enter Extra Details')"/>
            </div>
          </div>





          <div class="col-sm-12 col-md-6">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Blood Group"/>
              </label>

              <select v-model="donation.blood_type" required class="form-control">
                <option value="A+">A+ </option>
                <option value="A-">A- </option>
                <option value="AB+">AB+ </option>
                <option value="AB-">AB- </option>
                <option value="B+">B+ </option>
                <option value="B-">B- </option>
                <option value="O+">O+ </option>
                <option value="O-">O- </option>
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
    forceOutPermissionVerify(Permission.BLOOD_BANK_MANAGE_IO,this)
  },
  data(){
    const route = useRoute()
    window.currentPatientId= getQueryParameter("uid")
    return {
      patientName: getQueryParameter("name"),
      patientRef: getQueryParameter("ref"),
      patientId: window.currentPatientId,
      pageId:route.params.id,
      donation:{
        "operation":"DONATION"
      },
      fields:[
      ],

    }
  },
  mounted(){
    const context=this;
    if(this.pageId!=='create'){
      getRequestLoad_('/nx/donations/'+this.pageId,{},(u)=>{
        this.donation=u.donation;
        if(u.patient){
          this.patientName = u.patient.name;
          this.patientRef =u.patient.reference;
        }else{
          this.patientName = "Unknown Donor";
        }
      },()=>{
        alert("Connection error. Please refresh and try again.")
      })
    }else{
      this.donation.patient_ref = this.patientId??"unset";
    }
  },
  methods:{
    save(){
      const context=this;
      if(this.pageId==="create"){
        postRequestLoad_('/nx/donations/',this.donation,(fields)=>{
          context.$router.push('/nexus.bloodbank/donations')
          successToast(this.$t("Donation registered successfully"))
        })
      }else{
        postRequestLoad_('/nx/donations/'+this.pageId,this.donation,(fields)=>{
          successToast(this.$t("Donation updated successfully"))
        },()=>{
        })
      }
    }
  }
}
</script>