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
      <b-form-file
        v-model="fileKtp"
        :state="Boolean(fileKtp)"
        placeholder="Choose a file or drop it here..."
        drop-placeholder="Drop file here..."
      ></b-form-file>
      <div class="mt-3">Selected file: {{ fileKtp ? fileKtp.name : "" }}</div>
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
      fileKtp: null,
      lvlEducation: [],

      show: true,
    };
  },
  mounted() {
    this.fetchEducationlevel();
  },
  methods: {
    fetchEducationlevel() {
      // console.log(this.$parent.modulePage);
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
      let formData = new FormData();
      for (let key in this.form) {
        formData.append(key, this.form[key]);
      }
      formData.append("fileKtp", this.fileKtp);
      console.log(...formData);
      this.$parent
        .postApi("User/Register", formData)
        .then((response) => {
          if (response) {
            alert("Berhasil Register Dengan Id :" + this.form.userName);
            this.resetForm();
            this.$router.push("/user");
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
      this.fileKtp = null;
    },
  },
};
</script>