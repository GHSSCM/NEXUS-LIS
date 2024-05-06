import axios from 'axios';

const BASE_URL="http://localhost:8000/api";
export const getRequest_=(endpoint,params={},successFunction=()=>{},errorFunction=()=>{},finallyFunction=()=>{})=>{
    params.lab_ref=window.localStorage.getItem("lab_ref")??"lab_abc";
    axios.get(BASE_URL+endpoint,{params}).then((d)=>{
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
    var id=endpoint.split("/").join("");
    // setTimeout(function(){
       
    // },500);
    if (!$('#'+id).length) {
        $(".mainwrapper").append('<div id="'+id+'" class="d-flex flex-column align-items-center justify-content-center" style="height:100vh;width:100vw;position:fixed;top:0;bottom:0;left:0;right:0;background-color:rgba(0,0,0,0.1);z-index:9999999;"><div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span></div></div>');
    }
   getRequest_(endpoint,params,successFunction,errorFunction,()=>{
    if ($('#'+id).length) {
        $('#'+id).remove();
    }
        // setTimeout(function(){
           
        // },500);
   })
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
    axios.post(BASE_URL+endpoint,params).then((d)=>{
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