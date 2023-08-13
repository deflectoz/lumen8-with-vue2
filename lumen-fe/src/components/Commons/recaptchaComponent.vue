<template>
  <div>
    <div ref="recaptchaContainer"></div>
  </div>
</template>

<script>
export default {
  name: "MyCaptchaComponent",
  data() {
    return {
      sitekey: "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI", //Local
      recaptchaInstance: null,
      captchaVerified: false,
    };
  },
  mounted() {
    window.onRecaptchaLoad = () => {
      this.renderCaptcha();
    };

    const recaptchaScript = document.createElement("script");
    recaptchaScript.src =
      "https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit";
    recaptchaScript.setAttribute("async", "");
    recaptchaScript.setAttribute("defer", "");
    document.head.appendChild(recaptchaScript);
  },
  methods: {
    renderCaptcha() {
      const interval = setInterval(() => {
        if (window.grecaptcha) {
          window.grecaptcha.render(this.$refs.recaptchaContainer, {
            sitekey: this.sitekey,
            theme: "dark",
            callback: this.recaptchaVerify,
          });
          clearInterval(interval);
        }
      }, 500);
    },
    recaptchaVerify(response) {
      console.log(response);
      this.$emit("verify", response);
    },
  },
};
</script>
