import axios from 'axios';

const BASE_URL="http://localhost:8000/api";
export const getRequest_=(endpoint,params={},successFunction=()=>{},errorFunction=()=>{},finallyFunction=()=>{})=>{
    params.lab_ref=window.localStorage.getItem("lab_ref")??"lab_abc";
    axios.get(BASE_URL+endpoint,{params}).then((d)=>{
        successFunction(d.data);
        window.reloadComps();
    }).catch(e=>{
        console.error(e);
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
        errorFunction(e);
    }).finally(()=>{
        finallyFunction();
    })
}
