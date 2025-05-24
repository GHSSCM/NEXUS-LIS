<template>
   <div style="padding:1rem;">
      <Translate text="Installed Nexus Apps"/>
     <div class="row row-cols-3 g-3 pt-3 pb-3">
      
        <NuxtLink class="col text-center service-item" v-for="service in services" :key="service.name" :to="service.route">
          <div class="app-box mx-auto bg-gradient-info text-white" >
            <span v-html="service.icon"></span>
          </div>
          <div class="text-black" style="font-size: 9pt;">{{service.short_name}}</div>
        </NuxtLink>
     
     
    </div>
   </div>
</template>

<script>
export default {
  mounted(){
    console.log(this.$t("Summary"));
      this.loading=true;
      getRequest_(
        "/nx/services",
        {},
        (d)=>{
          this.services=d['data'];
        },
        (_)=>{},
        ()=>{
          this.loading=false
        }
      )
  },
  data(){
    return {
      loading:true,
      services:[]
    }
  }
}

</script>

<style scoped>
  .service-item:hover{
      opacity: 0.6;
  }
</style>