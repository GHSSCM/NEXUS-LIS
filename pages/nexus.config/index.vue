<template>
  <NuxtLayout name="configurationlayout">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">{{$t('Dashboard')}}</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="javascript:;">
                        <ion-icon name="home-outline"></ion-icon>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$t('Global Config')}}</li>
                  </ol>
                </nav>
              </div>
       
            </div>
            <!--end breadcrumb-->

            <div>
                     
              <h6 class="mb-0 text-uppercase"><Translate text="Configuration Data"/></h6>
              <hr/>
          

              <form @submit.prevent="save">

                <br/>

                <h3><Translate text="Global Config"/></h3>
                <hr/>
                <div class="row">
                  <div class="col-sm-12 col-md-6">

                  <div class="mb-4">
                      <label class="form-label"><Translate text="Facility Name"/></label>
                      <input v-model="lab.name" required class="form-control" type="text" :placeholder="$t('Facility Name')"/>
                    </div>

                  </div>

               
                  <div class="col-sm-12 col-md-6">

                      <div class="mb-4">
                          <label class="form-label"><Translate text="Currency Unit"/></label>
                          <input v-model="lab.meta.currency" required class="form-control" type="text" :placeholder="$t('Currency Unit')"/>
                        </div>

                  </div>
                </div>
                <br/>
              <!--  result sheet -->
                <div  v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_LABORATORY)">

                  <h3><Translate text="Result Sheet Config"/></h3>
                  <hr/>
                  <div class="col-sm-12 col-md-12">

                    <div class="mb-4">
                      <label class="form-label"><Translate text="Exportation header"/></label>

                      <textarea id="tinymce-editor-sheetheader" style="height:200px;width:100%"></textarea>

                    </div>

                  </div>

                  <!--
                                    <div class="col-sm-12 col-md-12">

                                        <div class="mb-4">
                                          <label class="form-label">Exportation footer</label>

                                          <textarea id="tinymce-editor-sheetfooter" style="height:200px;width:100%"></textarea>

                                        </div>

                                    </div> -->


                  <div class="col-sm-12 col-md-12">

                    <div class="mb-4">
                      <label class="form-label"><Translate text="Footer credits"/></label>

                      <textarea v-model="lab.meta.credits" class="form-control" :placeholder="$t('Footer credits')"></textarea>

                    </div>

                  </div>

                  <br/>
                  <br/>
                </div>
              <!--  result sheet end -->
<!--                result sheet -->
                <div v-if="serviceStore.serviceCodes.includes(ServiceCode.NEXUS_PATIENTS)">
                  <h3><Translate text="Patient Creation Config"/></h3>
                  <hr/>
                  <label><Translate text="Patient ID - Nomenclature"/></label>
                  <div class="row">

                    <div class="col-sm-12 col-md-4" >

                      <div class="mb-4">
                        <label class="form-label"><Translate text="Prefix (Optional)"/></label>
                        
                        <input v-model="lab.meta.patient_prefix" class="form-control" :placeholder="$t('Prefix')" required/>

                      </div>

                    </div> 
                    <div class="col-sm-12 col-md-4" >

                        <div class="mb-4">
                            <label class="form-label"><Translate text="Reset counter period"/></label>
                            <select class="form-control" v-model="lab.meta.patient_counterperiod" required>
                              <option value="daily">{{$t("Daily")}}</option>
                              <option value="monthly">{{$t("Monthly")}}</option>
                              <option value="yearly">{{$t("Yearly")}}</option>
                            </select>
                        </div>

                    </div> 
                    <div class="col-sm-12 col-md-4" >

                        <div class="mb-4">
                          <label class="form-label"><Translate text="Suffix (Optional)"/></label>
                          
                          <input v-model="lab.meta.patient_suffix" class="form-control" :placeholder="$t('Suffix')" required/>
                        </div>

                  </div> 
                  </div>


                  <br/>
                  <div class="d-flex flex-row justify-content-end">
                      <button type="submit" class="btn btn-primary w-100">+ <Translate text="Save"/></button>
                  </div>
                </div>
              </form>
              </div>

    
  

  </NuxtLayout>
</template>

  <script>

  import {useMyServicesStore} from "~/stores/services.js";
export default{

   async setup(){

     const serviceStore = useMyServicesStore();

     return{
       serviceStore,
     }

    },
    data(){
        return {
            lab:{
              meta:{
                credits:""
              }
            },
        }
    },
    mounted(){
        const context=this;

        getRequestLoad_('/lab',{},(r)=>{
            context.lab=r;
            const store = useMyPermissionsStore();
            store.labName = r.name;
            tinymce.init({
                license_key: 'gpl',
                selector: '#tinymce-editor-sheetheader',
                plugins: [
                  'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                  'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                images_upload_url: context.baseUrl+'/upload/image',
                mergetags_list: [
                  { value: 'First.Name', title: 'First Name' },
                  { value: 'Email', title: 'Email' },
                ],
                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
                init_instance_callback: function (editor) {
                  editor.setContent(r.meta.sheetheader??'<p></p>');
                }
            });
            // tinymce.init({
            //     license_key: 'gpl',
            //     selector: '#tinymce-editor-sheetfooter',
            //     plugins: [
            //       'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
            //       'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
            //     ],
            //     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            //     tinycomments_mode: 'embedded',
            //     tinycomments_author: 'Author name',
            //     images_upload_url: context.baseUrl+'/upload/image',
            //     mergetags_list: [
            //       { value: 'First.Name', title: 'First Name' },
            //       { value: 'Email', title: 'Email' },
            //     ],
            //     ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
            //     init_instance_callback: function (editor) {
            //       editor.setContent(r.meta.sheetfooter??'<p></p>');
            //     }
            // });
        })
    },
    methods:{
        save(){
            const context=this;
            var lab = this.lab;
            const editor1Instance = tinymce.get('tinymce-editor-sheetheader');
            // const editor2Instance = tinymce.get('tinymce-editor-sheetfooter');
            
            lab.meta.sheetheader = editor1Instance.getContent();
            // lab.meta.sheetfooter = editor2Instance.getContent();


            postRequestLoad_('/lab',lab,(configdata)=>{
              const store = useMyPermissionsStore();
              store.labName = lab.name;
                setAppConfig({
                  currency:this.lab.meta.currency
                });
                successToast(this.$t("Saved successfully"));
            })
        }
    }
}
</script>