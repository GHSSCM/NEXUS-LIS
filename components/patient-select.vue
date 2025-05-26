<template>
  <NuxtLayout :name="layoutName??'alllayout'">

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
              <Translate text="Select a patient" />
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
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
            <NuxtLink to="/nexus.patients/patientinfo/create" class="dropdown-item" v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_PATIENTS) && hasPermission(Permission.PATIENT_CREATE_PATIENT)">
              <Translate text="New patient" />
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>
    <!--end breadcrumb-->

    <div>
      <h6 class="mb-0 text-uppercase">
        <Translate :text="title??'Register a patient'" />
      </h6>
      <hr/>

      <div class="row">
        <div class="col-sm-12 col-md-3">
          <label for="single-select-field3" class="form-label">
            <Translate text="Patient Name" />
          </label>
        </div>
        <div class="col-sm-11 col-md-8">
          <div class="mb-4">
            <input v-model="searchname" @input="search" class="form-control" type="text" placeholder="Enter patient name"/>
          </div>
          <!-- <span  data-bs-toggle="popover" title="Help content" data-bs-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat" class=" fw-bold text-orange" style="cursor:pointer"> <i class="fadeIn animated bx bx-help-circle"></i> Need help?</span> -->
        </div>
        <div class="col-sm-1" v-if="searching">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>

      <div v-if="!searching && !searchname" >
        <h5>
          <Translate text="Enter a name to continue" />
        </h5>
      </div>
      <div v-if="searching" >
        <h5>
          <Translate text="Searching..." />
        </h5>
      </div>

      <div v-if="!searching && results.length>0">
        <h5>({{ results.length }}) <Translate text="similar patients" /></h5>
      </div>

      <div v-if="!searching && results.length==0 && searchname">
        <h5>
          <Translate text="Nothing found." />
        </h5>
      </div>

      <div class="card" v-if="searchname && results.length>0">
        <div class="card-body">
          <table class="table mb-0 table-hover">
            <thead>
            <tr>
              <th scope="col"><Translate text="#" /></th>
              <th scope="col"><Translate text="Name" /></th>
              <th scope="col"><Translate text="Age" /></th>
              <th scope="col"><Translate text="Profession" /></th>
              <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(r,i) in results" :key="'sr-'+i">
              <th scope="row">{{r.reference}}</th>
              <td>{{r.name}}</td>
              <td>{{ calculateAge(r.dob) }}</td>
              <td>{{r.profession}}</td>
              <td>
                <NuxtLink class="btn btn-sm btn-primary" :to="`${selectButtonCallBackLink}?name=${urlEncode(r.name)}&uid=${r.uniqid}&ref=${r.reference}`">
                  <Translate :text="selectButtonLabel??'View Details'" />
                </NuxtLink>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <br/>
      <br/>

      <div class="d-flex flex-row justify-content-end" v-if="searchname && serviceStore.serviceCodes.includes(ServiceCode.NEXUS_PATIENTS) && hasPermission(Permission.PATIENT_CREATE_PATIENT)" >
        <NuxtLink class="btn btn-primary w-100" :to="`/nexus.patients/patientinfo/create?name=${urlEncode(searchname)}`">
          <Translate text="+ Create New" />
        </NuxtLink>
      </div>
    </div>

  </NuxtLayout>
</template>
<script>
import {encodeURL} from "#app/composables/router.js";

export default{
  props:["layoutName","selectButtonLabel","selectButtonCallBackLink","title"],
  data(){
    return {
      searching: false,
      results: [],
      searchname: ""
    }
  },
  setup(){
    const serviceStore = useMyServicesStore();
    return{
      serviceStore
    }
  },
  mounted(){

  },
  methods:{
    urlEncode(string){
      return encodeURI(string)
    },
    calculateAge(dateString) {
      return calculateAge(dateString);
    },
    search(){
      if(!this.searchname){
        this.results=[];
        this.searching=false;
        return;
      }
      this.searching = true;
      const context = this;
      getRequest_('/search-patient',{query:this.searchname},(r)=>{
        context.results = r;
        context.searching = false;
      },()=>{ context.searching = false; })
    }
  }
}
</script>
