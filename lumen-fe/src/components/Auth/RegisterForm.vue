<template>
  <div>
    <b-form @submit.prevent="storeRegis">
      <b-form-group label="User Name:" label-for="input-1">
        <b-form-input
          v-model="form.userName"
          placeholder="Enter User Name"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Password:" label-for="input-1">
        <b-form-input
          type="password"
          v-model="form.password"
          placeholder="Enter Password"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="First Name:" label-for="input-1">
        <b-form-input
          v-model="form.firstName"
          placeholder="Enter First Name"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Last Name:" label-for="input-1">
        <b-form-input
          v-model="form.lastName"
          placeholder="Enter last Name"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Age:" label-for="input-1">
        <b-form-input
          v-model="form.age"
          placeholder="Enter Age"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-3"
        label="Education Level:"
        label-for="input-3"
      >
        <b-form-select
          v-model="form.idEducation"
          :options="lvlEducation"
          value-field="id"
          text-field="educationGrade"
        >
          <template #first>
            <b-form-select-option :value="null"
              >-- Pilih tingkat pendidikan --</b-form-select-option
            >
          </template>
        </b-form-select>
      </b-form-group>
      <b-button type="submit" variant="success">Register !</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        userName: null,
        password: null,
        firstName: null,
        lastName: null,
        age: null,
        idEducation: 0,
        methodType: "register",
      },
      lvlEducation: [],

      show: true,
    };
  },
  mounted() {
    this.fetchEducationlevel();
  },
  methods: {
    fetchEducationlevel() {
      console.log(this.$parent.modulePage);
      this.$parent
        .postApi(this.$parent.modulePage, {
          methodType: "getAll",
        })
        .then((response) => {
          console.log(response);
          this.lvlEducation = response.data[0];
        })
        .catch((error) => {
          console.error(error);
        });
    },
    storeRegis() {
      this.$parent
        .postApi("User/Register", this.form)
        .then((response) => {
          if (response) {
            alert("Berhasil Register Dengan Id :" + this.form.userName);
            this.resetForm();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    resetForm() {
      this.form.userName = null;
      this.form.password = null;
      this.form.firstName = null;
      this.form.lastName = null;
      this.form.age = null;
      this.form.idEducation = 0;
    },
  },
};
</script>