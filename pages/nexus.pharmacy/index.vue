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
                  },{
                    'label':'Create Anonymous Prescription',
                    'path':'/nexus.pharmacy/prescription/create'
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><!-- Icon from Prime Icons by PrimeTek - https://github.com/primefaces/primeicons/blob/master/LICENSE --><path fill="currentColor" d="M19 7.25h-.25V5A1.76 1.76 0 0 0 17 3.25a.7.7 0 0 0-.24 0l-11.9 4h-.27l-.17.06h-.14l-.16.09l-.12.17l-.14.12l-.11.1l-.12.15a.4.4 0 0 0-.08.1a2 2 0 0 0-.1.18l-.06.11a2 2 0 0 0-.07.22a.5.5 0 0 1 0 .11a2 2 0 0 0 0 .34v10A1.76 1.76 0 0 0 5 20.75h14A1.76 1.76 0 0 0 20.75 19V9A1.76 1.76 0 0 0 19 7.25m-1.92-2.49a.26.26 0 0 1 .17.24v2.25H9.62ZM19.25 19a.25.25 0 0 1-.25.25H5a.25.25 0 0 1-.25-.25V9A.25.25 0 0 1 5 8.75h14a.25.25 0 0 1 .25.25Z"/><circle cx="16.5" cy="14" r="1.25" fill="currentColor"/></svg>
                            <!-- <ion-icon name="wallet-outline" role="img" class="md hydrated" aria-label="wallet outline"></ion-icon> -->
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><!-- Icon from Material Symbols Light by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M8.117 16.539q.327 0 .548-.222q.22-.221.22-.549t-.222-.548t-.549-.22t-.548.222t-.22.549t.222.547t.549.22m0-3.769q.327 0 .548-.221q.22-.222.22-.55t-.222-.547t-.549-.22t-.548.221t-.22.55t.222.547t.549.22m0-3.769q.327 0 .548-.221q.22-.222.22-.55t-.222-.547t-.549-.22t-.548.221q-.22.222-.22.549t.222.548t.549.22m3.575 7.27h4.385q.213 0 .356-.145t.144-.356t-.144-.356t-.356-.144h-4.385q-.212 0-.356.144t-.144.357t.144.356t.356.143m0-3.769h4.385q.213 0 .356-.144t.144-.357t-.144-.356t-.356-.143h-4.385q-.212 0-.356.144t-.144.357t.144.356t.356.143m0-3.77h4.385q.213 0 .356-.143q.144-.144.144-.357t-.144-.356t-.356-.143h-4.385q-.212 0-.356.144t-.144.357t.144.356t.356.143M5.616 20q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h12.769q.69 0 1.153.463T20 5.616v12.769q0 .69-.462 1.153T18.384 20zm0-1h12.769q.23 0 .423-.192t.192-.424V5.616q0-.231-.192-.424T18.384 5H5.616q-.231 0-.424.192T5 5.616v12.769q0 .23.192.423t.423.192M5 5v14z"/></svg>
                            <!-- <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon> -->
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><!-- Icon from Material Symbols Light by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M8.117 16.539q.327 0 .548-.222q.22-.221.22-.549t-.222-.548t-.549-.22t-.548.222t-.22.549t.222.547t.549.22m0-3.769q.327 0 .548-.221q.22-.222.22-.55t-.222-.547t-.549-.22t-.548.221t-.22.55t.222.547t.549.22m0-3.769q.327 0 .548-.221q.22-.222.22-.55t-.222-.547t-.549-.22t-.548.221q-.22.222-.22.549t.222.548t.549.22m3.575 7.27h4.385q.213 0 .356-.145t.144-.356t-.144-.356t-.356-.144h-4.385q-.212 0-.356.144t-.144.357t.144.356t.356.143m0-3.769h4.385q.213 0 .356-.144t.144-.357t-.144-.356t-.356-.143h-4.385q-.212 0-.356.144t-.144.357t.144.356t.356.143m0-3.77h4.385q.213 0 .356-.143q.144-.144.144-.357t-.144-.356t-.356-.143h-4.385q-.212 0-.356.144t-.144.357t.144.356t.356.143M5.616 20q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h12.769q.69 0 1.153.463T20 5.616v12.769q0 .69-.462 1.153T18.384 20zm0-1h12.769q.23 0 .423-.192t.192-.424V5.616q0-.231-.192-.424T18.384 5H5.616q-.231 0-.424.192T5 5.616v12.769q0 .23.192.423t.423.192M5 5v14z"/></svg>

                            <!-- <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon> -->
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><!-- Icon from Prime Icons by PrimeTek - https://github.com/primefaces/primeicons/blob/master/LICENSE --><path fill="currentColor" d="M19 7.25h-.25V5A1.76 1.76 0 0 0 17 3.25a.7.7 0 0 0-.24 0l-11.9 4h-.27l-.17.06h-.14l-.16.09l-.12.17l-.14.12l-.11.1l-.12.15a.4.4 0 0 0-.08.1a2 2 0 0 0-.1.18l-.06.11a2 2 0 0 0-.07.22a.5.5 0 0 1 0 .11a2 2 0 0 0 0 .34v10A1.76 1.76 0 0 0 5 20.75h14A1.76 1.76 0 0 0 20.75 19V9A1.76 1.76 0 0 0 19 7.25m-1.92-2.49a.26.26 0 0 1 .17.24v2.25H9.62ZM19.25 19a.25.25 0 0 1-.25.25H5a.25.25 0 0 1-.25-.25V9A.25.25 0 0 1 5 8.75h14a.25.25 0 0 1 .25.25Z"/><circle cx="16.5" cy="14" r="1.25" fill="currentColor"/></svg>

                            <!-- <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon> -->
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