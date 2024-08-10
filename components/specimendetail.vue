<template>
  <!--  start here /! -->
  <div class="row" v-if="specimen">

        
    <div class="col-sm-7">

    </div>
    <div class="col-sm-5 d-flex">
     <NuxtLink class="btn btn-primary btn-sm my-3 mb-5" target="_blank" v-if="meta.validated" :to="baseUrl+'/test-report?id='+specimen.id">View Single PDF</NuxtLink>
     <a class="btn btn-primary btn-sm my-3 mb-5 ms-4" target="_blank" v-if="meta.validated"  :download="'test-report-'+specimen.patient.name.trim().split(' ').join('-')+'-'+specimen.test.name.trim().split(' ').join('-')+'.pdf'" :href="baseUrl+'/test-report?id='+specimen.id+'&dl=true'">Download Single PDF</a>
    </div>

    <!-- <div class="col-sm-12 my-4 mt-0">
        <p>Tests</p>
        <ol>
            <li>{{specimen.test.name}}; {{specimen.specimen.name}}.</li>
            <li v-if="specimen.others" v-for="(sp,i) in specimen.others">{{sp.test.name}}; {{sp.specimen.name}}.</li>
        </ol>
    </div> -->
    <div class="col-sm-12 col-md-4">
        <p><b>Received:</b> {{specimen.receptiondate}}  {{specimen.receptiontime}}</p>
    </div>


    <div class="col-sm-12 col-md-4">
        <p><b>Preleveur:</b> {{specimen.preleveur}}</p>
    </div>



    <div class="col-sm-12 col-md-4">
        <p><b>Physician:</b> {{specimen.physician}}</p>
    </div>


    <div class="col-sm-12 col-md-12" v-if="meta.enteredby">
        <p><b>Entered by:</b> {{meta.enteredby}}</p>
    </div>

    <div class="col-sm-12 col-md-12" v-if="meta.verifiedby">
        <p><b>Verified by:</b> {{meta.verifiedby}}</p>
    </div>

    <div class="col-sm-12 col-md-12" v-if="specimen.referredout">
        <p><b>Referred from:</b> {{specimen.referredto}}</p>
    </div>

    

    <div class="col-sm-12 my-2">

    </div>

    <div class="col-sm-12 col-md-4">
        <p><b>Specimen:</b> {{specimen.specimen.name}}</p>
    </div>
    <div class="col-sm-12 col-md-8">
        <p><b>Description:</b> {{specimen.specimen.description}}</p>
    </div>

    <div class="col-sm-12 my-2">

    </div>


    <div class="col-sm-12 col-md-4">
        <p><b>Test:</b> {{specimen.test.name}}</p>
    </div>


    <div class="col-sm-12 col-md-8">
        <p><b>Description:</b> {{specimen.test.description}}</p>
    </div>


    <div class="col-sm-12 col-md-4">
        <p><b>Expected TAT:</b> {{specimen.test.tat}} {{specimen.test.tatunit}}</p>
    </div>

    <div class="col-sm-12 col-md-4">
        <p><b>Expected Cost:</b> {{specimen.test.cost}} {{curr}}</p>
    </div>


    <div class="col-sm-12 col-md-4">
        <p><b>Test type:</b> {{specimen.test.type}}</p>
    </div>



    <div class="col-sm-12 my-2">

    </div>




</div>
<!-- end here /! -->

</template>

<script>
export default{
    props:["specimen","meta","baseUrl"]
}
</script>