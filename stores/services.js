import { defineStore } from 'pinia'

export const useMyServicesStore = defineStore('myServicesStore',{
  // id: 'myPermissionsStore',
  state: () => {
  
   return {
      services:[],
       serviceCodes:[],
      loadedServices:false,
       checkAfterLoad:[],
    }
  },
  actions: {
    async loadServices(){

            if(process.client){
                this.services = window.localStorage.getItem("current_user_services")?JSON.parse( window.localStorage.getItem("current_user_services")):[];
            }
            const data = await new Promise((resolve, reject) => {
                getRequestLoad_('/nx/services/', {}, (res) => {
                    if (res) {
                        resolve(res);
                    } else {
                        reject(new Error("Invalid response"));
                    }
                }, ()=>{
                    reject(new Error("Failed to load services"));
                });
            });

            this.services = data.data;
            this.serviceCodes = data.data.map(x=>x.code)
            this.loadedServices = true;

            // Run any callbacks
            this.checkAfterLoad.forEach(c => {
                if (typeof c.func === 'function') {
                    c.func();
                }
            });

            this.checkAfterLoad = [];

            if(process.client){
                window.localStorage.setItem("current_user_services", JSON.stringify(this.services));
            }
    }
  }
})
