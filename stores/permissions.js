import { defineStore } from 'pinia'

export const useMyPermissionsStore = defineStore('myPermissionsStore',{
  // id: 'myPermissionsStore',
  state: () => {
  
   return {
      permissions:[],
      loadedPermissions:false,
      checkAfterLoad:[],
      labName:"",
      showManual:false
    }
  },
  actions: {
     loadPermissions(){
        try {
          this.permissions = window.localStorage.getItem("current_user_perm")?JSON.parse( window.localStorage.getItem("current_user_perm")):[];
          const context = this;
          getRequestLoad_('/permissions/', {}, (data) => {
            var permissions = data.permissions;
            context.labName=data.labName;
            context.permissions = permissions;
            context.loadedPermissions=true;
            context.checkAfterLoad.forEach(c=>{
              // alert("Executing: "+c.perm)
              // console.log("EXECUTING,",perm)
              if(c.func){
                c.func();
              }else{

              forceOutPermissionVerify(c.perm,c.context);

              }
              
            })
            context.checkAfterLoad=[];
            window.localStorage.getItem(JSON.stringify(permissions))
          });
        } catch (error) {
          console.error('Failed to load permissions:', error);
        }
    }
  }
})
