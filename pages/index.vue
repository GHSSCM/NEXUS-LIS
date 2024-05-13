<template>

    <div class="wrapper " style="background-color: white; position:absolute;top:0;left:0;right:0;bottom:0;width:100%;height:100%;">

    </div>

</template>
<script>
    export default{
        mounted() {
            if(window.localStorage.getItem("user")==null){
                return this.$router.push("/login");
            }else{
                return this.$router.push("/patients");
            }
        },
    }
</script>