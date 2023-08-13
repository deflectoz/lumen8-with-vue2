<template>
  <div id="app">
    <b-container>
      <nav-component v-if="showNav" />
      <router-view></router-view>
    </b-container>
  </div>
</template>

<script>
import nav from "@/components/Commons/navComponent.vue";

export default {
  name: "App",
  components: {
    "nav-component": nav,
  },
  computed: {
    showNav() {
      const currentRoute = this.$route;
      return currentRoute.path !== "/login";
    },
  },
};
</script>

<style>
</style>
