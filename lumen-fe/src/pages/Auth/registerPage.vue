<template>
  <div>
    <br />
    <register-form />
  </div>
</template>

<script>
import register from "@/components/Auth/RegisterForm.vue";
import globalFunc from "@/libs/globalFunc.vue";

export default {
  extends: globalFunc,
  components: {
    "register-form": register,
  },
};
</script>