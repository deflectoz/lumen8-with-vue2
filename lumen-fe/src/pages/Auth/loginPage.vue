<template>
  <div>
    <h1>Login Page</h1>
    <login-form></login-form>
  </div>
</template>

<script>
import LoginForm from '@/components/Auth/LoginForm.vue';

export default {
  components: {
    'login-form': LoginForm
  }
};
</script>