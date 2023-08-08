<template>
  <div> 
    <form @submit.prevent="submitLogin">
      <b-form-group label="Username" label-for="userName">
        <b-form-input v-model="userName" id="userName" required></b-form-input>
      </b-form-group>
      <b-form-group label="Password" label-for="password">
        <b-form-input type="password" v-model="password" id="password" required></b-form-input>
      </b-form-group>
      <b-button type="submit" variant="primary">Login</b-button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      userName: '',
      password: ''
    };
  },
  methods: {
    submitLogin() {
      const apiUrl = process.env.VUE_APP_API_URL;
      axios.post(`${apiUrl}/login`, {
        userName: this.userName,
        password: this.password
      }).then(response => {
              console.log(response.data)
          })
          .catch(error => {
               console.error(error);
          });
    }
  }
};
</script>