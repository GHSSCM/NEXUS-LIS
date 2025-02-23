import { defineStore } from 'pinia'

export const useMyPermissionsStore = defineStore('myPermissionsStore',{
  // id: 'myPermissionsStore',
  state: () => ({
     permissions:[]
   }),
  actions: {
     loadPermissions(){
        try {
          const context = this;
          getRequestLoad_('/permissions/', {}, (permissions) => {
            context.permissions = permissions;
          });
        } catch (error) {
          console.error('Failed to load permissions:', error);
        }
    }
  }
})
