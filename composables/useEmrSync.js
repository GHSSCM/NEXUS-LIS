import { ref, onMounted, onUnmounted } from 'vue'

export const useEmrSync = () => {
  const isEmrOnline = ref(true)
  let syncInterval = null

  onMounted(() => {
    if (process.client) {
      syncInterval = setInterval(async () => {


        await new Promise(resolve =>{
            getRequest_("/emr/process-pending",{},(res)=>{
              // res = r;
              console.log("EMR Sync Status: ", res);
              isEmrOnline.value = res.connected === true
            }, (err) => {
              console.error("Error fetching EMR sync status:", err)
              isEmrOnline.value = false
            }, ()=>{
                resolve()
            })
        })
        // try {
        //   getReq
        //   const res = await $fetch('/api')
        //   isEmrOnline.value = res.connected === true
        // } catch (e) {
        //   isEmrOnline.value = false
        // }

        // Promise.

        // const getData = ()=> {
            // getRequest_("/emr/process-pending",{},(res)=>{
            //   res = res.data;
            //   console.log("EMR Sync Status: ", res);
            //   isEmrOnline.value = res.connected === true
            // }, (err) => {
            //   console.error("Error fetching EMR sync status:", err)
            //   isEmrOnline.value = false
            // }, ()=>{
              
            // })
        // }


      }, 10000)
    }
  })

  onUnmounted(() => {
    if (syncInterval) clearInterval(syncInterval)
  })

  return {
    isEmrOnline
  }
}
