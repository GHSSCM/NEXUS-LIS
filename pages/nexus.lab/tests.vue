<template>
  <NuxtLayout name="lablayout">
    
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">
        <Translate text="Nexus Lab"/>
      </div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0 align-items-center">
            <li class="breadcrumb-item">
              <a href="javascript:;">
                <ion-icon name="home-outline"></ion-icon>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <Translate text="Tests"/>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!--end breadcrumb-->
  
    <div>
      <!-- start -->
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <h4 class="mb-2">
                <Translate text="Tests"/>
              </h4>
              <br/>
  
              <div class="table-responsive">
                <div class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                  <div class="row">
                    <div class="col-sm-12">
                      <table id="onetoabc" class="table table-striped table-bordered dttable" role="grid" aria-describedby="example2_info">
                        <thead>
                          <tr role="row">
                            <th rowspan="1" colspan="1"></th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Patient"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Specimen"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Test"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Physician"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Received On"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Referred?"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Facility"/>
                            </th>
                            <th rowspan="1" colspan="1"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr role="row" v-for="(u,i) in specimens" :class="i % 2 === 0 ? 'even' : 'odd'" :key="'account-'+i">
                            <td>{{ i + 1 }}</td>
                            <td>{{ u.patient.name }}</td>
                            <td>{{ u.specimen.name }}</td>
                            <td>{{ u.test.name }}</td>
                            <td>{{ u.physician }}</td>
                            <td>{{ u.received.receptiondate }} {{ u.received.receptiontime }}</td>
                            <td>{{ u.referredout ? $t("Out") : (u.referredin ? $t("In") : "") }}</td>
                            <td>{{ u.referredto ?? "" }}</td>
                            <td>
                              <NuxtLink class="btn btn-success btn-sm me-3" v-if="u.meta && u.meta.enteredby && !u.meta.validated && (hasPermission('LABORATORY.VALIDATE_RESULTS'))" :to="'/nexus.lab/viewspecimen/'+u.id">
                                <Translate text="Verify"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3" v-else-if="u.meta && !u.meta.enteredby && !u.meta.validated && hasPermission('LABORATORY.ENTER_RESULTS')" :to="'/nexus.lab/viewspecimen/'+u.id">
                                <Translate text="Enter Results"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3" :to="'/nexus.lab/viewspecimen/'+u.id" v-if="hasPermission('LABORATORY.ENTER_RESULTS') || hasPermission('LABORATORY.VALIDATE_RESULTS') || hasPermission('LABORATORY.VIEW_TEST_RESULTS') ">
                                <Translate text="View"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.meta && !u.meta.enteredby && !u.meta.validated && hasPermission('LABORATORY.REGISTER_SPECIMEN')" :to="'/nexus.lab/editspecimen/'+u.id">
                                <Translate text="Edit"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3" :to="'/nexus.patients/profile/'+u.patient.id" v-if="hasPermission('PATIENT.VIEW_PATIENT_PROFILE')">
                                <Translate text="Patient profile"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3"  v-if="u.meta && u.meta.validated && hasPermission('LABORATORY.EXPORT_SHEET')" :to="'/nexus.lab/visualizer/'+u.id">
                                <Translate text="Export PDF"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.billing&&hasPermission('LABORATORY.MANAGE_BILLING')" :to="'/nexus.lab/initbilling/specimen/'+u.id">
                                <Translate text="Generate Bill"/>
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary btn-sm me-3" v-else-if="hasPermission('LABORATORY.MANAGE_BILLING')" target="_blank" :to="baseUrl+'/bill-report?id='+u.billing.id">
                                <Translate text="View Bill"/>
                              </NuxtLink>
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th rowspan="1" colspan="1"></th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Patient"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Specimen"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Test"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Physician"/>
                            </th>
                            <th rowspan="1" colspan="1">
                              <Translate text="Received On"/>
                            </th>
                            <th rowspan="1" colspan="1"></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- tab ends here -->
            </div>
          </div>
        </div>
      </div>
      <!-- end -->
    </div>
  </NuxtLayout>
</template>


  <script>
  export default{
    setup(){
      
      forceOutPermissionVerify('LABORATORY.VIEW_TEST_RESULTS,LABORATORY.ENTER_RESULTS,LABORATORY.VALIDATE_RESULTS',this); 
    },
    data(){
        return {
          specimens:[],
          baseUrl:getBaseUrl()
        };
    },
    mounted(){
      const context=this;
      getRequestLoad_('/tests/',{},(specimens)=>{
        context.specimens= specimens;
        setTimeout(() => {
          loadDataTables();
        }, 500);
      });
    }
  }
  </script>