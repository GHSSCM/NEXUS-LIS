<template>
  <NuxtLayout name="nodrawerlayout">
      
            <!--start breadcrumb-->

            <!--end breadcrumb-->

            <div class="container">
              <div class="h-full d-flex flex-column align-items-center justify-content-center mb-3">
                  <img src="../assets/cropped-HBR-logo.png" style="height: 100px;" alt="">
                <h2 class="text-white mt-4 mb-2">HealthBridge Nexus v1.0.0</h2>
                <p class=" text-white"> Choose a service</p>

              <!--items-->

                <div class="row row-cols-1 row-cols-lg-3">
                  <div class="col"  v-for="service in services" :key="service.name">
                    <a class="card radius-10 service-card-content " :href="service.route" >
                      <div class="card-body text-white">
                        <div class="service-box bg-white text-primary bg-gradient ">
                            <span v-html="service.icon" class="text-white"></span>
                        </div>
                        <h5 class="text-black">{{service.name}}</h5>
                        <p class="mb-0 text-black-50">{{service.description}}</p>
                      </div>
                    </a>
                  </div>
                </div>
              </div>


            </div>

    
  

  </NuxtLayout>
</template>
<script>
export default {
  data(){
    return {
      services:[

      ]
    }
  },
  
  mounted() {
    getRequestLoad_(
        '/nx/services',
        {},
        (x)=>{
            this.services = x.data;
        }

    )
  }
}
</script>
<style scoped>

.top-header {
   background:transparent;
 }

.service-card-content:hover{
  opacity: 0.8;
}
</style>
<script setup lang="ts">
</script>