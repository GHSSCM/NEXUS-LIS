<template>
    <NuxtLayout name="patientlayout">

              <!--start breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3"><Translate text="Nexus Patients"/></div>
                <div class="ps-3">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                      <li class="breadcrumb-item"><a href="javascript:;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><!-- Icon from Covid Icons by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 20.679a3.429 3.429 0 1 0 0-6.858a3.429 3.429 0 0 0 0 6.858m-.571-9.429h1.142m-.571 0v2.571m3.839-1.218l.808.808m-.404-.404l-1.819 1.819m3.576 1.853v1.142m0-.571h-2.571m1.218 3.839l-.808.808m.404-.404l-1.819-1.819m-1.853 3.576h-1.142m.571 0v-2.571m-3.839 1.218l-.808-.808m.404.404l1.819-1.819m-3.576-1.853v-1.142m0 .571h2.571m-1.218-3.839l.808-.808m-.404.404l1.819 1.819M7.5 9a4.125 4.125 0 1 0 0-8.25A4.125 4.125 0 0 0 7.5 9M.75 17.25a6.753 6.753 0 0 1 9.4-6.208"/></svg>
                        </a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                  </nav>
                </div>



              </div>
              <!--end breadcrumb-->

              <HasNoPermission perm="PATIENT.VIEW_PATIENTS">
                <div style="height:80vh;width:100%;display:flex;align-items: center; justify-content: center; flex-direction:column">
                    <img src="/assets/cropped-HBR-logo.png" class="" style="height: 100px;"/>
                    <h1><Translate text="HealthBridge Nexus Patients!"/></h1>
                    <p><Translate text="Choose an option from the menu"/></p>
                </div>

              </HasNoPermission>


              <HasPermission perm="PATIENT.VIEW_PATIENTS">

                <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4" style="display:none;">
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Total Revenue</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-purple">
                            <ion-icon name="wallet-outline" role="img" class="md hydrated" aria-label="wallet outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">$92,854</h4>
                          </div>
                          <div class="ms-auto">+6.32%</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Total Customer</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">48,789</h4>
                          </div>
                          <div class="ms-auto">+12.45%</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Total Orders</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-danger">
                            <ion-icon name="bag-handle-outline" role="img" class="md hydrated" aria-label="bag handle outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">88,234</h4>
                          </div>
                          <div class="ms-auto">+3.12%</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-start gap-2">
                          <div>
                            <p class="mb-0 fs-6">Conversion Rate</p>
                          </div>
                          <div class="ms-auto widget-icon-small text-white bg-gradient-success">
                            <ion-icon name="bar-chart-outline" role="img" class="md hydrated" aria-label="bar chart outline"></ion-icon>
                          </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                          <div>
                            <h4 class="mb-0">48.76%</h4>
                          </div>
                          <div class="ms-auto">+8.52%</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <h6 class="mb-0 text-uppercase">
                  <Translate text="Registered Patients" />
                </h6>
                <hr/>
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <div class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">

                        <div class="row">
                          <div class="col-sm-12">
                            <table id="onetoabc" class="table table-striped table-bordered dttable " role="grid" aria-describedby="example2_info">
                              <thead>
                              <tr role="row">
                                <th rowspan="1" colspan="1"></th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Patient ID" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Name" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Adress" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Age" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Registered On" />
                                </th>
                                <th></th>
                              </tr>
                              </thead>
                              <tbody>

                              <tr role="row" v-for="(u,i) in users" :class="i % 2 === 0 ? 'even' : 'odd'" :key="'account-'+i">
                                <td class="">{{ i+1 }}</td>
                                <td class="">{{ u.reference }}</td>
                                <td class="">{{ u.name }}</td>
                                <td class="sorting_1">{{ u.address }}</td>
                                <td>{{ calculateAge(u.dob) }}</td>
                                <td>{{ u.created_at.split("T")[0] }}</td>
                                <!-- <td>{{u.created_at.split(".")[0].split("T").join(" ")}}</td> -->
                                <td>
                                  <NuxtLink class="btn btn-primary btn-sm me-2" :to="'/nexus.patients/profile/'+u.id"  v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_PATIENTS) &&hasPermission('PATIENT.VIEW_PATIENT_PROFILE')">
                                    <Translate text="View Profile" />
                                  </NuxtLink>
                                  <NuxtLink class="btn btn-primary btn-sm" :to="'/nexus.lab/addspecimen/'+u.id" v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_LABORATORY) && hasPermission('LABORATORY.REGISTER_SPECIMEN')">
                                    <Translate text="Add Specimen" />
                                  </NuxtLink>
                                </td>
                              </tr>
                              </tbody>
                              <tfoot>
                              <tr>
                                <th rowspan="1" colspan="1"></th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Patient ID" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Name" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Adress" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Age" />
                                </th>
                                <th rowspan="1" colspan="1">
                                  <Translate text="Registered On" />
                                </th>
                                <th></th>
                              </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

              </HasPermission>




    </NuxtLayout>
  </template>
<script>
export default{
  setup(){
    const  serviceStore = useMyServicesStore();
    return {
      serviceStore
    }
  },
  data(){
    return {
      users:[]
    }
  },
  methods:{
    calculateAge(dob){
      return calculateAge(dob);
    }
  },
  mounted(){
    const context=this;
    getRequestLoad_('/patients',{},(users)=>{
      context.users= users;
      setTimeout(() => {
        loadDataTables();
      }, 1000);
    })
  }
}
</script>