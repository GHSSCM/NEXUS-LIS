<template>
  <NuxtLayout name="patientlayout">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Nexus Patients" />
              </div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                      <a href="javascript:;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><!-- Icon from Covid Icons by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 20.679a3.429 3.429 0 1 0 0-6.858a3.429 3.429 0 0 0 0 6.858m-.571-9.429h1.142m-.571 0v2.571m3.839-1.218l.808.808m-.404-.404l-1.819 1.819m3.576 1.853v1.142m0-.571h-2.571m1.218 3.839l-.808.808m.404-.404l-1.819-1.819m-1.853 3.576h-1.142m.571 0v-2.571m-3.839 1.218l-.808-.808m.404.404l1.819-1.819m-3.576-1.853v-1.142m0 .571h2.571m-1.218-3.839l.808-.808m-.404.404l1.819 1.819M7.5 9a4.125 4.125 0 1 0 0-8.25A4.125 4.125 0 0 0 7.5 9M.75 17.25a6.753 6.753 0 0 1 9.4-6.208"/></svg>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <Translate text="Patients" />
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="ms-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-primary">
                    <Translate text="Options" />
                  </button>
                  <button type="button"
                    class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown">
                    <span class="visually-hidden">
                      <Translate text="Toggle Dropdown" />
                    </span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" v-if="hasPermission('PATIENT.MODIFY_PATIENT_INFO')">
                    <NuxtLink class="dropdown-item" to="/nexus.patients/new/patient">
                      <Translate text="New patient" />
                    </NuxtLink>

          

                  </div>
                </div>
              </div>
            </div>
            <!--end breadcrumb-->

            <div>
              
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
                                        <td >
                                            <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 5px;max-width:400px">
                                              <NuxtLink class="btn btn-primary btn-sm me-2 mt-2" :to="'/nexus.patients/profile/'+u.id"  v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_PATIENTS) &&hasPermission('PATIENT.VIEW_PATIENT_PROFILE')">
                                            <Translate text="View Profile" />
                                          </NuxtLink>
                                          <NuxtLink class="btn btn-primary btn-sm me-2 mt-2" :to="'/nexus.lab/addspecimen/'+u.id" v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_LABORATORY) && hasPermission('LABORATORY.REGISTER_SPECIMEN')">
                                            <Translate text="Add Specimen" />
                                          </NuxtLink>
                                        
                                          <NuxtLink class="btn btn-primary btn-sm me-2 mt-2" :to="`/nexus.billing/bill/create?name=${urlEncode(u.name)}&uid=${u.uniqid}&ref=${u.reference}`"  v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_BILLING) && hasPermission('LABORATORY.MANAGE_BILLING')">
                                              <Translate text="Create a bill" />
                                          </NuxtLink>
                                          <NuxtLink class="btn btn-primary btn-sm me-2 mt-2" :to="`/nexus.bloodbank/transfusion/create?name=${urlEncode(u.name)}&uid=${u.uniqid}&ref=${u.reference}`"  v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_BLOOD_BANK) && hasPermission('BLOODBANK.MANAGE_IO')">
                                            <Translate text="Register Blood Transfusion" />
                                          </NuxtLink>
                                         
                                          <NuxtLink class="btn btn-primary btn-sm me-2 mt-2" :to="`/nexus.bloodbank/donation/create?name=${urlEncode(u.name)}&uid=${u.uniqid}&ref=${u.reference}`"  v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_BLOOD_BANK) && hasPermission('BLOODBANK.MANAGE_IO')">
                                            <Translate text="Register Blood Donation" />
                                          </NuxtLink>
                                            </div>
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

            </div>
  </NuxtLayout>
</template>


<script>
export default{
  data(){
    return {
      users:[]
    }
  },
  methods:{
    calculateAge(dob){
      return calculateAge(dob);
    },
    urlEncode(string){
      return encodeURI(string)
    },
  },
  mounted(){
    const context=this;
      getRequestLoad_('/patients',{},(users)=>{
        context.users= users;
        setTimeout(() => {
          loadDataTables();
        }, 1000);
      })
  },

  setup(){
    const serviceStore = useMyServicesStore();
    return{
      serviceStore
    }
  }
}
</script>