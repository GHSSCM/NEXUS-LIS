<script setup>
const { isEmrOnline } = useEmrSync()
</script>

<template>
  <!-- <div class="bg-red-500 text-white p-2 text-center text-sm">
    ⚠️ EMR Server Not Reachable
  </div> -->
   <div  v-if="!isEmrOnline" style="width:100%;height:10px;background:grey">⚠️EMR Server Not Reachable</div>
    <!-- <div  v-else="!isEmrOnline" style="width:100%;height:10px;background:red"></div> -->
</template>

<script >
const { isEmrOnline } = useEmrSync()
</script>

<style>

</style>