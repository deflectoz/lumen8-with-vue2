<template>
  <div>
    <form @submit.prevent="submitLogin">
      <b-form-group label="Username" label-for="userName">
        <b-form-input v-model="userName" id="userName" required></b-form-input>
      </b-form-group>
      <b-form-group label="Password" label-for="password">
        <b-form-input
          type="password"
          v-model="password"
          id="password"
          required
        ></b-form-input>
      </b-form-group>
      <vue-recaptcha
        ref="recaptcha"
        sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
      ></vue-recaptcha>
      <b-button type="submit" variant="primary">Login</b-button>
    </form>
  </div>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";

export default {
  components: {
    VueRecaptcha,
  },
  data() {
    return {
      userName: "",
      password: "",
    };
  },
  methods: {
    submitLogin() {
      // console.log(this.$parent.generateEncryptedApiKey());

      this.$parent
        .postApi(this.$parent.modulePage, {
          userName: this.userName,
          password: this.password,
          methodType: "login",
        })
        .then((response) => {
          console.log(response.data.metadata.code);
          if (response.data.metadata.code === 200) {
            const token = response.data.response.token;
            localStorage.setItem("token", token);
            alert("Berhasil Login");
            this.$router.push("/dashboard");
          }
        })
        .catch((error) => {
          console.error(error);
          alert(error);
        });
    },
  },
};
</script>