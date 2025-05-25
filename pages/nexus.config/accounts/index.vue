<template>
  <NuxtLayout name="configurationlayout">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Nexus Config"/>
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
                      <Translate text="Accounts"/>
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="ms-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-primary">
                    <Translate text="Options"/>
                  </button>
                  <button type="button"
                    class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown">
                    <span class="visually-hidden">
                      <Translate text="Toggle Dropdown"/>
                    </span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <!--  <a class="dropdown-item" href="javascript:;">Action</a> -->
                    <NuxtLink class="dropdown-item" to="/accounts/create">
                      <Translate text="Create new account"/>
                    </NuxtLink>
                    <!-- <a class="dropdown-item" href="javascript:;">Something else here</a> -->
                    <!-- <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a> -->
                  </div>
                </div>
              </div>
            </div>
            <!--end breadcrumb-->

            <div>
              <h6 class="mb-0 text-uppercase">
                <Translate text="Registered Accounts"/>
              </h6>
              <hr/>
              <div class="card">
                  <div class="card-body">
                      <div class="table-responsive">
                          <div class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                              <div class="row">
                                <div class="col-sm-12">
                                  <table id="oneto" class="table table-striped table-bordered dttable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                      <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">
                                          <Translate text="ID"/>
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">
                                          <Translate text="Name"/>
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 243.533px;" aria-label="Position: activate to sort column descending" aria-sort="ascending">
                                          <Translate text="Username"/>
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 104px;" aria-label="Office: activate to sort column ascending">
                                          <Translate text="Email"/>
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 46px;" aria-label="Age: activate to sort column ascending">
                                          <Translate text="Phone"/>
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 100.533px;" aria-label="Start date: activate to sort column ascending">
                                          <Translate text="Registered on"/>
                                        </th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr role="row" v-for="(u,i) in accounts" :class="i % 2 === 0 ? 'even' : 'odd'" :key="'account-'+i">
                                        <td class="">{{ u.id }}</td>
                                        <td class="">{{ u.name }}</td>
                                        <td class="sorting_1">{{ u.username }}</td>
                                        <td>{{ u.email }}</td>
                                        <td>{{ u.phone }}</td>
                                        <td>{{ u.created_at.split(".")[0].split("T").join(" ") }}</td>
                                        <td>
                                          <NuxtLink class="btn btn-primary btn-sm" :to="'/nexus.config/accounts/'+u.id">
                                            <Translate text="View/Edit account"/>
                                          </NuxtLink>
                                        </td>
                                      </tr>
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <th rowspan="1" colspan="1">
                                          <Translate text="ID"/>
                                        </th>
                                        <th rowspan="1" colspan="1">
                                          <Translate text="Name"/>
                                        </th>
                                        <th rowspan="1" colspan="1">
                                          <Translate text="Username"/>
                                        </th>
                                        <th rowspan="1" colspan="1">
                                          <Translate text="Email"/>
                                        </th>
                                        <th rowspan="1" colspan="1">
                                          <Translate text="Phone"/>
                                        </th>
                                        <th rowspan="1" colspan="1">
                                          <Translate text="Registered on"/>
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
    setup(){
        forceOutPermissionVerify('CONFIGURATION.MANAGE_APP_CONFIG',this) 
    },
  data(){
    return {
      accounts:[]
    }

  },
  mounted(){
    const context=this;
        getRequestLoad_('/accounts',{},(accounts)=>{
                context.accounts =accounts;
        })
  }
}
</script>