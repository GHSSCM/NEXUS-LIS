<template>
  <NuxtLayout name="inner">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Dashboard"/>
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
                      <Translate text="Lab Sections"/>
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
                    <NuxtLink class="dropdown-item" to="/lab-section/create">
                      <Translate text="New Section"/>
                    </NuxtLink>
                  </div>
                </div>
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
                              <Translate text="Lab Sections"/>
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
                                            <Translate text="Name"/>
                                          </th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Description"/>
                                          </th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Techniques"/>
                                          </th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Creation date"/>
                                          </th>
                                          <th></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr role="row" v-for="(u,i) in labsections" :class="i%2==0?'even':'odd'" :key="'account-'+i">
                                          <td class="">{{ i+1 }}</td> 
                                          <td class="">{{ u.name }}</td>
                                          <td class="">{{ u.description }}</td>
                                          <td>{{ (u.techniques ?? []).join(",") }}</td>
                                          <td class="sorting_1">{{ u.created_at.split(".")[0].split('T').join(" ") }}</td>
                                          <td>
                                            <NuxtLink class="btn btn-primary btn-sm" :to="'/lab-section/'+u.id">
                                              <Translate text="View/Edit"/>
                                            </NuxtLink>
                                          </td>
                                        </tr>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <th rowspan="1" colspan="1"></th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Name"/>
                                          </th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Description"/>
                                          </th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Techniques"/>
                                          </th>
                                          <th rowspan="1" colspan="1">
                                            <Translate text="Creation date"/>
                                          </th>
                                          <th></th>
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
        forceOutPermissionVerify('MANAGE_APP_CONFIG',this) 
    },
    mounted(){
      const context=this;
      getRequestLoad_('/lab-sections/',{},(labsections)=>{
        context.labsections= labsections;
        setTimeout(() => {
          loadDataTables();
        }, 500);
      })
    },
    data(){
      return {
        labsections:[]
      }
    },
    methods:{
      duplicateData(d){
      // const context=this;
      // if(window.confirm("Are you sure you want to duplicate this sec: "+d.name+" ?")){
      //   getRequestLoad_(
      //     "/duplicate-specimen/"+d.id,
      //     {},
      //     (r)=>{
      //         successToast(this.$t("Duplicated successfully"));

      //         context.$router.push("/lb/specimentype/"+r.id);
              
      //     }
      //   )
      // }
    }
    }
  }
</script>