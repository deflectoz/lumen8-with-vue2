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
      <recaptchaComponentVue @verify="captchaVerified"></recaptchaComponentVue>
      <b-button type="submit" variant="primary">Login</b-button>
    </form>
  </div>
</template>

<script>
import recaptchaComponentVue from "@/components/Commons/recaptchaComponent.vue";

export default {
  components: {
    recaptchaComponentVue,
  },
  data() {
    return {
      userName: "",
      password: "",
      isCaptchaVerified: false,
    };
  },
  methods: {
    captchaVerified(response) {
      this.$parent
        .postApi(this.$parent.modulePage, {
          secret: "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe",
          response: response,
          methodType: "captcha",
        })
        .then((response) => {
          console.log(response);
          this.isCaptchaVerified = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    submitLogin() {
      if (this.isCaptchaVerified) {
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
      } else {
        alert("Pastikan Captca Sudah Di Isi !!");
      }
    },
  },
};
</script>