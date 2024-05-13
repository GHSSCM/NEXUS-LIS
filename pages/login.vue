<script>
export default {
  setup () {
    useHead({
      bodyAttrs: {
        class: 'bg-white'
      }
    })
  },
  mounted() {
    if(window && window.localStorage.getItem("user")){
          this.$router.push("/patients");
        }
      if(typeof window !="undefined"){
        this.loadScript();
       
      }
    },
    methods: {
      login(){
        const context=this;
        postRequestLoad_('/login',{username:this.username,password:this.password},(user)=>{
              successToast("Login successful!");
              window.localStorage.setItem("user",JSON.stringify(user));
              window.localStorage.setItem("lab_ref",user.lab_ref);
              context.$router.push('/patients');   
        });
      },
      loadScript() {
        console.log("Load script");

        var s=[
        { src: '/assets/js/main.js' }
      
      ];

      for(var i=0;i<s.length;i++){

        var elementToRemove = document.getElementById("script_"+i);

          // Check if the element exists before attempting to remove it
          if (elementToRemove) {
              // Find the parent node of the element
              var parentElement = elementToRemove.parentNode;

              // Remove the element from its parent
              parentElement.removeChild(elementToRemove);
          }

        // Load your script here
        const script = document.createElement('script');
        script.id="script_"+i;
        script.src = s[i].src;
        script.async = true;
        document.body.appendChild(script);
      }
      
      }
    },
    data(){
      return {
        username:"",
        password:""
      }
    }
}
</script>

<template>

  <!--start wrapper-->
  <div class="wrapper mainwrapper">
    <div class="">
      <div class="row g-0 m-0">
        <div class="col-xl-6 col-lg-12">
          <div class="login-cover-wrapper">
            <div class="card shadow-none">
              <div class="card-body">
                <div class="text-center">
                  <h4>Welcome Back !</h4>
                  <p>Sign In to your account</p>
                </div>
                <form class="form-body row g-3" @submit.prevent="login">
          
                  <div class="col-12">
                    <label for="inputEmail" class="form-label">Username *</label>
                    <input required v-model="username" type="text" class="form-control" id="inputUsername">
                  </div>
                  <div class="col-12">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input required v-model="password" type="password" class="form-control" id="inputPassword">
                  </div>
                  <div class="col-12 col-lg-6">
                    <!-- <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckRemember">
                      <label class="form-check-label" for="flexSwitchCheckRemember">Remember Me</label>
                    </div> -->
                  </div>
                  <div class="col-12 col-lg-6 text-end d-none">
                    <a href="authentication-reset-password-cover.html">Forgot Password?</a>
                  </div>
                  <div class="col-12 col-lg-12">
                     <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Sign In</button>  
                    </div>
                  </div>
                  <div class="col-12 col-lg-12 d-none">
                    <div class="position-relative border-bottom my-3">
                      <div class="position-absolute seperator translate-middle-y">or continue with</div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-12 d-none">
                    <div class="social-login d-flex flex-row align-items-center justify-content-center gap-2 my-2">
                      <a href="javascript:;" class=""><img src="assets/images/icons/facebook.png" alt=""></a>
                      <a href="javascript:;" class=""><img src="assets/images/icons/apple-black-logo.png" alt=""></a>
                      <a href="javascript:;" class=""><img src="assets/images/icons/google.png" alt=""></a>
                    </div>
                  </div>
                  
                    <div class="col-12 col-lg-12 text-center d-none">
                        <p class="mb-0">Don't have an account? <a href="authentication-sign-up-cover.html">Sign up</a></p>
                      </div>
                
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-12">
          <div class="position-fixed top-0 h-100 d-xl-block d-none login-cover-img">
         
          </div>
        </div>

        <img src="assets/logo.png" style="width:100px; bottom:90px; right:50px" class="position-absolute "/> 
      </div>
      <!--end row-->
    </div>
  </div>
  <!--end wrapper-->

</template>