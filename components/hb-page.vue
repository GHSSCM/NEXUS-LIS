<script>
export default {
  props: ['layoutName','title','sectionSvgIcon','options', 'sectionName'],
}
</script>

<template>
  <NuxtLayout :name="layoutName??'configurationlayout'">

    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3"><Translate :text="sectionName??'Nexus'"/></div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0 align-items-center">
            <li class="breadcrumb-item"><a href="javascript:;">
              <span v-html="sectionSvgIcon??'<ion-icon name=\'home-outline\'></ion-icon>'"></span>
            </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"></li>
          </ol>
        </nav>
      </div>

      <HbOptionsMenu v-if="options" :options="options"/>

    </div>
    <!--end breadcrumb-->


    <div v-if="title">
      <h6 class="mb-0 text-uppercase">
        <Translate :text="title" />
      </h6>
      <hr/>
    </div>

    <slot></slot>




  </NuxtLayout>
</template>

<style scoped>

</style>