<template>
  <NuxtLayout name="inner">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3"><Translate text="Dashboard"/></div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="javascript:;">
                        <ion-icon name="home-outline"></ion-icon>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><Translate text="Visualize Result Result Sheet"/></li>
                  </ol>
                </nav>
              </div>
              <div class="ms-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-primary"><Translate text="Options"/></button>
                  <button type="button"
                    class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"> <span class="visually-hidden"><Translate text="Toggle Dropdown"/></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" target="_blank"
                  :href="baseUrl+'/test-report?id='+theid+'&dl=true'"><Translate text="Export"/></a>
                   <a class="dropdown-item" href="javascript:;" @click="updateData"><Translate text="Update data"/></a>
                   <a class="dropdown-item" href="javascript:;" @click="deleteData"><Translate text="Reset data"/></a>
                 <!-- <a class="dropdown-item" href="javascript:;">Something else here</a>
                  <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a> -->
                </div>
              </div>
            </div>

          </div>
            <!--end breadcrumb-->

            <div>
                     
              <h6 class="mb-0 text-uppercase"><Translate text="Page"/></h6>
              <hr/>
            </div>

            <textarea id="tinymce-editor-export-sheet" style="height:100vh;width:100%"></textarea>

  </NuxtLayout>
</template>


<script>
export default {
  data(){
    const route =  useRoute();
    return {
      baseUrl:getBaseUrl(),
      theid:route.params.id
    }
  },
  methods:{
    updateData(){
      const route=useRoute();
      const editorInstance = tinymce.get('tinymce-editor-export-sheet');
      const currentContent = editorInstance.getContent();
      console.log(currentContent);
      postRequestLoad_('/test-report-save',{
        'html':currentContent,
        'registered_specimen':route.params.id
      },(fields)=>{
          successToast(this.$t("Updated successfully"))
      })
    },
    deleteData(){
      const route=useRoute();
      if(confirm(this.$t('Are you sure you want to reset this sheet?'))){
        getRequestLoad_('/test-report-delete',{
          'id':route.params.id,
          'preview':true
        },(data)=>{
          const editorInstance = tinymce.get('tinymce-editor-export-sheet');
            if (editorInstance) {
              editorInstance.setContent(data.data);
            }
            successToast(this.$t("Updated successfully"))
          
        })
      }
    }
  },
  mounted(){
    const route=useRoute();
    // tinymce.init({
    //   license_key: 'z5d6ta0mgjiawtx0omdb2w68bidc8kxmmkdeyp5ru6zakrle',
    //   selector: '#tinymce-editor',
    //   skin: false, // Disables online skins (optional)
    //   content_css: false, // Uses local styles
    //   plugins: 'autolink lists link image media table code',
    //   toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code',
    //   menubar: false
    // });
    const context=this;
    getRequestLoad_('/test-report-data?preview=true&id='+route.params.id,{},(res)=>{
    
      tinymce.init({
        license_key: 'gpl',
        selector: '#tinymce-editor-export-sheet',
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
          editor.setContent(res.data);
        },

        // // ...

        // // Tell TinyMCE that header, footer, and main are valid
        // extended_valid_elements: 'header[name|class],footer[name|class],main[name|class]',
        
        // // Also let body contain header, footer, or main
        // valid_children: '+body[header|footer|main]',


        // cleanup: false,
        // verify_html: false


      });
    });

  }
}
</script>
<style>

</style>