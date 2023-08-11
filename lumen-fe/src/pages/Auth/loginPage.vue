<template>
  <div>
    <h1>Login Page</h1>
    <login-form></login-form>
  </div>
</template>

<script>
import LoginForm from "@/components/Auth/LoginForm.vue";
import globalFunc from "@/libs/globalFunc.vue";
export default {
  extends: globalFunc,
  components: {
    "login-form": LoginForm,
  },
  mounted() {
    console.log(this.generateEncryptedApiKey);
  },
};
</script>