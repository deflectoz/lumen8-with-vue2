<template>
  <div>
    <br />
    <router-link :to="{ name: 'register' }">
      <b-button variant="info" size="sm">Register</b-button>
    </router-link>
    <br />
    <br />

    <common-table :items="this.items" :fields="this.fields"></common-table>
  </div>
</template>

<script>
import tableComponent from "@/components/Commons/tableComponent.vue";
import globalFunc from "@/libs/globalFunc.vue";

export default {
  extends: globalFunc,
  components: {
    "common-table": tableComponent,
  },
  data() {
    return {
      fields: [
        {
          key: "firstName",
          label: "First Name",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "lastName",
          label: "Last Name",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "firstName",
          label: "First Name",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "userName",
          label: "User Name",
          sortable: true,
          sortDirection: "desc",
        },

        {
          key: "age",
          label: "Age",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "educationGrade",
          label: "Education Grade",
          sortable: true,
          sortDirection: "desc",
        },
        { key: "actions", label: "Actions" },
      ],
      items: [],
    };
  },
  mounted() {
    this.fetchUser();
  },
  methods: {
    fetchUser() {
      this.getApi(this.modulePage + "/getAllUser")
        .then((response) => {
          //   console.log(Response.data.data);
          this.items = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    register() {
      alert("Ok");
    },
  },
};
</script>