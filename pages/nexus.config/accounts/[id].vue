<template>
    <NuxtLayout name="lablayout">
        
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">
              <Translate text="Nexus Config"/>
            </div>
            <div class="ps-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item">
                    <a href="javascript:;">
                      <ion-icon name="home-outline"></ion-icon>
                    </a>
                  </li>
                  <li v-if="pageId=='create'" class="breadcrumb-item active" aria-current="page">
                    <Translate text="New User Account"/>
                  </li>
                  <li v-else class="breadcrumb-item active" aria-current="page">
                    <Translate text="Edit User Account"/>
                  </li>
                </ol>
              </nav>
            </div>
            <!-- Commented block remains unchanged -->
        </div>
        <!--end breadcrumb-->
  
        <div>
            <h6 class="mb-0 text-uppercase" v-if="pageId=='create'">
              <Translate text="Create a new account"/>
            </h6>
            <h6 class="mb-0 text-uppercase" v-else>
              <Translate text="Edit Account"/> <span class="text-primary" v-if="ogname">({{ogname}})</span>
            </h6>
            <small>
              <Translate text="Fields marked with (*) are obligatory"/>
            </small>
            <hr/>
            <form @submit.prevent="save">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label class="form-label">
                      <Translate text="Full Name * "/>
                    </label>
                    <input v-model="name" required class="form-control" type="text" :placeholder="$t('Enter Full Name')"/>
                  </div>
                </div>
  
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label class="form-label">
                      <Translate text="Username *"/>
                    </label>
                    <input v-model="username" :disabled="pageId!='create'" required class="form-control" type="text" :placeholder="$t('Enter username here')"/>
                  </div>
                </div>
  
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label class="form-label">
                      <Translate text="Phone Number"/>
                    </label>
                    <input v-model="phone" class="form-control" type="text" :placeholder="$t('Enter Phone number here')"/>
                  </div>
                </div>
  
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label class="form-label">
                      <Translate text="Email"/>
                    </label>
                    <input v-model="email" class="form-control" type="email" :placeholder="$t('Enter email here')"/>
                  </div>
                </div>
  
                <hr v-if="pageId!='create'"/>
  
                <small v-if="pageId!='create'">
                  <strong>
                    <Translate text="Set a new password only if you want to change the old password"/>
                  </strong>
                  <br/><br/>
                </small>
  
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label v-if="pageId=='create'" class="form-label">
                      <Translate text="Password *"/>
                    </label>
                    <label v-else class="form-label">
                      <Translate text="Password"/>
                    </label>
                    <input v-model="password" :required="pageId=='create'" class="form-control" type="password" :placeholder="$t('Enter Password Here')"/>
                  </div>
                </div>
  
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label v-if="pageId=='create'" class="form-label">
                      <Translate text="Retype Password *"/>
                    </label>
                    <label v-else class="form-label">
                      <Translate text="Retype Password"/>
                    </label>
                    <input v-model="password2" :required="pageId=='create'" class="form-control" type="password" :placeholder="$t('Retype Password Here')"/>
                  </div>
                </div>
  
                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                    <label class="form-label">
                      <Translate text="Permissions"/>
                    </label>
                    <multiselect v-model="perms" :options="permissions" multiple></multiselect>
                  </div>
                </div>
              </div>
  
              <br/>
              <br/>
              <br/>
              <button class="btn btn-primary w-100" style="border:0">
                + <Translate text="Save"/>
              </button>
            </form>
        </div>
  
    </NuxtLayout>
</template>

  <script>
export default{
    setup(){
        forceOutPermissionVerify('CONFIGURATION.MANAGE_APP_CONFIG',this) 
    },
    watch: {
    username(newValue) {
      // Replace every space with an underscore
      this.username = newValue.replace(/ /g, '_')
    }
  },
    data(){
        const route = useRoute()
        const id = route.params.id;
        return {
            name:"",
            username:"",
            email:"",
            password:"",
            password2:"",
            phone:"",
            pageId:id,
            ogname:null,
            permissions:[],
            perms:[]
        }
    },
    mounted(){
        const context=this;
        if(this.pageId!=='create'){
            getRequestLoad_('/account/'+this.pageId,{},(u)=>{
                context.name=u.name;
                context.ogname=u.name.split(" ")[0];
                context.username=u.username;
                context.email=u.email;
                context.phone=u.phone;
                context.permissions = u.permissions;
                context.perms = u.perms;
            },()=>{
                // alert("Connection error. Please refresh and try again.")
            })
        }else{

            getRequestLoad_('/permissions-available/',{},(u)=>{
                context.permissions = u;
            },()=>{
                // alert("Connection error. Please refresh and try again.")
            })
        }
    },
    methods:{
        save(){
            if(this.password!=this.password2){
                errorToast(this.$t("The two passwords do not match"))
                return;
            }
            const context=this;
            if(this.pageId=="create"){
                    postRequestLoad_('/account',this.$data,(fields)=>{
                        context.$router.push('/accounts')
                        successToast(this.$t("Account created successfully"))
                    })
            }else{
                postRequestLoad_('/account/'+this.pageId,this.$data,(fields)=>{
                    // context.$router.push('/accounts')
                    context.ogname=context.name.split(" ")[0];
                    successToast(this.$t("Account updated successfully"))
                },()=>{
                    // alert("Connection error. Please refresh and try again.")
                })
            }
        }
    }
}
</script>