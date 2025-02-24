

<template>
  <NuxtLayout name="inner">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Dashboard" />
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
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" v-if="hasPermission('MODIFY_PATIENT_INFO')">
                    <NuxtLink class="dropdown-item" to="/new/patient">
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
                                        <td>
                                          <NuxtLink class="btn btn-primary btn-sm me-2" :to="'/profile/'+u.id"  v-if="hasPermission('VIEW_PATIENT_PROFILE')">
                                            <Translate text="View Profile" />
                                          </NuxtLink>
                                          <NuxtLink class="btn btn-primary btn-sm" :to="'/addspecimen/'+u.id" v-if="hasPermission('REGISTER_SPECIMEN')">
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