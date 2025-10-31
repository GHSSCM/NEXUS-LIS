<template>
    <div class=" border-0 d-flex flex-row align-items-center p-2 mt-4 " >
      <img :src="logo||'../assets/cropped-HBR-logo.png'" alt="Hospital Logo" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
      <div class="text-start">
        <h6 class="mb-0 fw-bold text-white">{{name??"Facility"}}</h6>
        <small class="text-white">{{slogan??"HealthBridge Nexus"}}</small>
      </div>
  </div>
</template>

<script >
  export default {
    data(){
      let branding={};
      if(process.client){
         try{
          branding = localStorage.getItem('branding')?JSON.parse(localStorage.getItem('branding')):{};
         }catch(e){
            console.error('Error parsing branding from localStorage:', e);
            branding = {};
         }
      }
      return {
        logo:null,
        name:null,
        slogan:null,
        ...branding,
      } 
    },
    mounted(){
        getRequest_(
            '/nx/branding',
            {},
            (response)=>{
                this.logo = response.logo;
                this.name = response.name;
                this.slogan = response.slogan;
                // this.color = response.data.color;
                localStorage.setItem('branding', JSON.stringify(response));
            }
        )
    }
  }
</script>

<style>

</style>