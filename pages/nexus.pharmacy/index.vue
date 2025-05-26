<template>
    <NuxtLayout name="pharmacylayout">

              <!--start breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3"><Translate text="Nexus Pharmacy"/></div>
                <div class="ps-3">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                      <li class="breadcrumb-item"><a href="javascript:;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 26 26"><!-- Icon from Pepicons Pencil by CyCraft - https://github.com/CyCraft/pepicons/blob/dev/LICENSE --><g fill="currentColor"><path fill-rule="evenodd" d="m18.85 13.192l-6.365-6.364a4 4 0 0 0-5.657 5.657l6.364 6.364a4 4 0 1 0 5.657-5.657M7.535 7.536a3 3 0 0 1 4.242 0l6.364 6.364a3 3 0 1 1-4.242 4.242l-6.364-6.364a3 3 0 0 1 0-4.242" clip-rule="evenodd"/><path d="m16.037 10.58l-.243.97c-1.201-.3-2.223-.154-3.101.432c-.87.58-1.454 1.687-1.73 3.355l-.987-.164c.318-1.917 1.032-3.27 2.162-4.023c1.122-.748 2.434-.936 3.899-.57"/><path fill-rule="evenodd" d="M13 24.5c6.351 0 11.5-5.149 11.5-11.5S19.351 1.5 13 1.5S1.5 6.649 1.5 13S6.649 24.5 13 24.5m0 1c6.904 0 12.5-5.596 12.5-12.5S19.904.5 13 .5S.5 6.096.5 13S6.096 25.5 13 25.5" clip-rule="evenodd"/></g></svg>
                        </a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                  </nav>
                </div>


                <HbOptionsMenu :options="[{
                    'label':'Create Prescription',
                    'path':'/nexus.pharmacy/select-patient'
                  }]"></HbOptionsMenu>


              </div>
              <!--end breadcrumb-->


              <div>


                <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Revenue (this month)</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                            <ion-icon name="wallet-outline" role="img" class="md hydrated" aria-label="wallet outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">{{ stats.revenueMonth??0 }} {{getAppConfig("currency")}}</h4>
                          </div>
                          <div class="ms-auto">    </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Paid Prescriptions (this month)</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">{{ stats.billCountMonth??0 }}</h4>
                          </div>
                          <div class="ms-auto">  </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Total Paid Prescriptions</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">{{ stats.billCount??0 }}</h4>
                          </div>
                          <div class="ms-auto">  </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Total Revenue</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">{{ stats.revenue??0 }}  {{getAppConfig("currency")}}</h4>
                          </div>
                          <div class="ms-auto">  </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>







      <HbTable url="/nx/nexus-prescriptions/" title="Prescriptions Made"></HbTable>






              </div>




    </NuxtLayout>
  </template>

<script>
export default{
  mounted(){
    getRequestLoad_(
        '/nx/nexus-prescription-stats',
        {},
        (x)=>{
          this.stats.revenue=x.total_amount;
          this.stats.billCount =x.total_count;


          this.stats.revenueMonth=x.monthly_data.total_amount;
          this.stats.billCountMonth =x.monthly_data.total_count;
        }
    )
  },data(){
    return{
      stats:{}
    }
  }
}
  </script>