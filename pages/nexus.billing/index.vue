<template>
    <NuxtLayout name="billinglayout">

              <!--start breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3"><Translate text="Nexus Biling"/></div>
                <div class="ps-3">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                      <li class="breadcrumb-item"><a href="javascript:;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><!-- Icon from Stash Icons by Pingback LLC - https://github.com/stash-ui/icons/blob/master/LICENSE --><path fill="currentColor" d="M7.179 3.5h5.642c.542 0 .98 0 1.333.029c.365.03.685.093.981.243a2.5 2.5 0 0 1 1.092 1.093c.151.296.214.616.244.98c.029.355.029.792.029 1.334v3.071a.5.5 0 0 1-1 0V7.2c0-.568 0-.964-.026-1.273c-.024-.302-.07-.476-.138-.608a1.5 1.5 0 0 0-.655-.656c-.132-.067-.305-.113-.608-.137c-.309-.026-.705-.026-1.273-.026H7.2c-.568 0-.964 0-1.273.026c-.302.024-.476.07-.608.137a1.5 1.5 0 0 0-.656.656c-.067.132-.113.306-.137.608C4.5 6.236 4.5 6.632 4.5 7.2v9.6c0 .568 0 .965.026 1.273c.024.302.07.476.137.608a1.5 1.5 0 0 0 .646.65l.01.002c.018.004.062.014.144.026q.189.028.495.05c.404.03.92.05 1.466.064c1.089.027 2.265.027 2.826.027a.5.5 0 0 1 0 1h-.001c-.56 0-1.748 0-2.85-.027a33 33 0 0 1-1.515-.066a8 8 0 0 1-.566-.058a1.5 1.5 0 0 1-.453-.122a2.5 2.5 0 0 1-1.093-1.092c-.15-.296-.213-.616-.243-.98C3.5 17.8 3.5 17.362 3.5 16.82V7.18c0-.542 0-.98.029-1.333c.03-.365.093-.685.243-.981a2.5 2.5 0 0 1 1.093-1.093c.296-.15.616-.213.98-.243c.355-.03.793-.03 1.335-.03"/><path fill="currentColor" d="M18.62 12.5c.403 0 .735 0 1.006.022c.281.023.54.072.782.196a2 2 0 0 1 .874.874c.124.243.173.501.196.782c.022.27.022.603.022 1.005v2.242c0 .402 0 .734-.022 1.005c-.023.281-.072.54-.196.782a2 2 0 0 1-.874.874c-.243.124-.501.173-.782.196c-.27.022-.603.022-1.005.022h-4.242c-.402 0-.734 0-1.005-.022c-.281-.023-.54-.072-.782-.196a2 2 0 0 1-.874-.874c-.124-.243-.173-.501-.196-.782c-.022-.27-.022-.603-.022-1.005v-2.242c0-.402 0-.734.022-1.005c.023-.281.072-.54.196-.782a2 2 0 0 1 .874-.874c.243-.124.501-.173.782-.196c.27-.022.603-.022 1.005-.022zm-5.164 1.019c-.22.018-.332.05-.41.09a1 1 0 0 0-.437.437c-.04.078-.072.19-.09.41l-.004.044h7.97l-.004-.044c-.018-.22-.05-.332-.09-.41a1 1 0 0 0-.437-.437c-.078-.04-.19-.072-.41-.09a13 13 0 0 0-.944-.019h-4.2c-.428 0-.72 0-.944.019M20.5 16.5h-8v1.1c0 .428 0 .72.019.944c.018.22.05.332.09.41a1 1 0 0 0 .437.437c.078.04.19.072.41.09c.225.019.516.019.944.019h4.2c.428 0 .72 0 .944-.019c.22-.018.332-.05.41-.09a1 1 0 0 0 .437-.437c.04-.078.072-.19.09-.41c.019-.225.019-.516.019-.944zm-14-10a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zM6 10a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 6 10m.5 2.5a.5.5 0 0 0 0 1H10a.5.5 0 0 0 0-1zM6 17a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 6 17"/></svg>
                        </a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                  </nav>
                </div>


                <HbOptionsMenu :options="[{
                    'label':'Create Bill',
                    'path':'/nexus.billing/select-patient'
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
                            <p class="mb-0 fs-6">Paid Bills Generated(this month)</p>
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
                            <p class="mb-0 fs-6">Total Paid Bills Generated</p>
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







      <HbTable url="/nx/nexus-bills/" title="Generated Bills"></HbTable>






              </div>




    </NuxtLayout>
  </template>

<script>
export default{
  mounted(){
    getRequestLoad_(
        '/nx/nexus-billing-stats',
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