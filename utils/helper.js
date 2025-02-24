import axios from 'axios';
import { useMyPermissionsStore } from '~/stores/permissions'
import { useI18n } from 'vue-i18n'

export const BASE_URL="http://localhost:8000/api";

export const trans_=(x)=>{
    const { t,locale } = useI18n() 
    const { setLocale } = useI18n();
    locale.value = getUserLang();
    setLocale( getUserLang());
    return t(x);
}
export const getBaseUrl=()=>{
    if(window){
        return (isLocal?(window.location.origin+"/api"):BASE_URL);
    }else{
        return BASE_URL;
    }
    
}
export const getUserLang=()=>{
    
    if(!process.client){
        return "en";
    }
   return window.localStorage.getItem("user_lang")??"en"
}

export const setUserLang=(lgn)=>{
    if(!process.client){
        return;
    }
  window.localStorage.setItem("user_lang",lgn)
  window.location.reload();
 }
export const generateRandomStringWithTimestamp=(length)=> {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomString = '';
    
    for (let i = 0; i < length; i++) {
        randomString += characters.charAt(Math.floor(Math.random() * characters.length));
    }

    const timestamp = Date.now();
    return `${randomString}-${timestamp}`;
}

// const BASE_URL="https://d1a6-41-202-219-172.ngrok-free.app/api";
// const BASE_URL="http://ghsscm-lis.novobyte-sarl.com/api";
export const getRequest_=(endpoint,params={},successFunction=()=>{},errorFunction=()=>{},finallyFunction=()=>{})=>{
    params.lab_ref=window.localStorage.getItem("lab_ref")??"lab_abc"
    var currentUser = window.localStorage.getItem("user");
    if(currentUser && endpoint=="/permissions/"){
        currentUser = JSON.parse(currentUser).id;
        params.user_id = currentUser;
    }
    axios.get((isLocal?(window.location.origin+"/api"):BASE_URL)+endpoint,{params}).then((d)=>{
        successFunction(d.data);
        window.reloadComps();
    }).catch(e=>{
        console.error(e);
        handleAxiosError(e);
        errorFunction(e);
    }).finally(()=>{
        finallyFunction();
    })
}

export const getRequestLoad_=(endpoint,params={},successFunction=()=>{},errorFunction=()=>{},finallyFunction=()=>{})=>{
    var id=endpoint.split("/").join("").split("?").join("").split("&").join("").split("=").join("");
    // setTimeout(function(){
       
    // },500);
    if (!$('#'+id).length) {
        $(".mainwrapper").append('<div id="'+id+'" class="d-flex flex-column align-items-center justify-content-center" style="height:100vh;width:100vw;position:fixed;top:0;bottom:0;left:0;right:0;background-color:rgba(0,0,0,0.1);z-index:9999999;"><div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span></div></div>');
    }

   getRequest_(endpoint,params,successFunction,errorFunction,()=>{
        if ($('#'+id).length) {
            $('#'+id).remove();
        }
   });
   
}



export const postRequestLoad_=(endpoint,params={},successFunction=()=>{},errorFunction=()=>{},finallyFunction=()=>{})=>{
    var id=endpoint.split("/").join("");
    if (!$('#'+id).length) {
        $(".mainwrapper").append('<div id="'+id+'" class="d-flex flex-column align-items-center justify-content-center" style="height:100vh;width:100vw;position:fixed;top:0;bottom:0;left:0;right:0;background-color:rgba(0,0,0,0.1);z-index:9999999;"><div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span></div></div>');
    }
    postRequest_(endpoint,params,successFunction,errorFunction,()=>{
        if ($('#'+id).length) {
            $('#'+id).remove();
        }
    })
 }
 

// 
export const postRequest_=(endpoint,params={},successFunction=()=>{},errorFunction=()=>{},finallyFunction=()=>{})=>{
    params.lab_ref=window.localStorage.getItem("lab_ref")??"lab_abc";
    axios.post((isLocal?(window.location.origin+"/api"):BASE_URL)+endpoint,params).then((d)=>{
        successFunction(d.data);
        window.reloadComps();
    }).catch(e=>{
        console.error(e);
        handleAxiosError(e);
        errorFunction(e);
    }).finally(()=>{
        finallyFunction();
    })
}

export const hasPermission=(perm)=>{
    console.log("TESTING FOR "+perm)
  const store = useMyPermissionsStore()
  var split = perm.split(",");
  for(var i=0;i<=split.length;i++){
    if(store.permissions.includes(split[i])){
        console.log("returning true. includes")
        return true;
    }
  }
  return false;
}

export const forceOutPermissionVerify=(perm,context)=>{
    // return;
    const store = useMyPermissionsStore();
    //if has not loaded permissions yet, add it to the list.
    if(store.loadedPermissions){
        console.log("checking perm", perm)
        if(!hasPermission(perm)){
            if(context){
                context.$router.push("/");
            }
            if(!process.client){
                return;
            }
            return window.location.href='/';
        }
    }else{
        console.log("not yet loaded perm. come back later",perm)
        store.checkAfterLoad.push({perm,context});
    }
   
}
export const successToast=(ms)=>{
    Lobibox.notify('success', {
		pauseDelayOnHover: true,
		size: 'mini',
		rounded: true,
		icon: 'bx bx-check-circle',
		delayIndicator: false,
		continueDelayOnInactiveTab: false,
		position: 'top right',
		msg: ms
	});
}

export const errorToast=(ms)=>{
    Lobibox.notify('error', {
		pauseDelayOnHover: true,
		size: 'mini',
		rounded: true,
		icon: 'bx bx-x-circle',
		delayIndicator: false,
		continueDelayOnInactiveTab: false,
		position: 'top right',
		msg: ms
	});
}

const handleAxiosError=(error)=>{
    if (error.response) {
        // The request was made and the server responded with a status code
        console.log('Status Code:', error.response.status);
        console.log('Data:', error.response.data);
        console.log('Headers:', error.response.headers);
        errorToast(error.response.data.message);
      } else if (error.request) {
        // The request was made but no response was received
        console.log('Request:', error.request);
      } else {
        // Something happened in setting up the request that triggered an error
        console.log('Error:', error.message);
        errorToast(error.message);
      }
      console.log('Config:', error.config);
}

export const calculateAge = (dateString) =>{
    if(!dateString){
        return "";
    }
    const today = new Date();
    const birthDate = new Date(dateString);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    // If the birth month is greater than the current month, or if it's the same month but the birth day
    // is greater than the current day, we subtract 1 from the age
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    
    return age;
}

export const loadDataTables=()=>{
    
    var dts = $('.dttable');
    for(var i=0;i<dts.length;i++){
        var table = $(dts[i]).DataTable( {
            order:[[1,'asc']],
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
     
        table.buttons().container()
            .appendTo( '.dttable_wrapper .col-md-6:eq(0)' );
    }
}
export const getAppConfig=(param)=>{
    const d=  window.localStorage.getItem("lis_config");
    if(!d){
        return null;
    }
    try{
        const e = JSON.parse(d);
        return e[param];
    }catch(e){
        return null;
    }
}

export const setAppConfig=(data)=>{
   if(typeof data =='string'){
    window.localStorage.setItem("lis_config",data);
   }else{
        window.localStorage.setItem("lis_config",JSON.stringify(data));
   }
}


// // Function to break circular reference in production. had an error
// export const  getComponent = (this)=>{
//     // Get an array of property names
//     const keys = Object.keys(this.$data);

//     const data={};
//     // Iterate through each property name and access its value
//     keys.forEach(key => {
//       console.log(`${key}:`, this[key]);
//       data[key]=
//     });
// }