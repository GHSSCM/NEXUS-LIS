<template>
  <slot v-if="!hasPermission(perm??'')"></slot>
</template>

<script >
 import { useMyPermissionsStore } from '@/stores/permissions';
 export default{
  setup(){
    const permissionsStore = useMyPermissionsStore()
    permissionsStore.loadPermissions();
    return {permissionsStore};
  },
  props:[
    'perm'
  ]
 }
</script>

<style>

</style>