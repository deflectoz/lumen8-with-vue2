<script>
import axios from "axios";
// import CryptoJS from "crypto-js";

export default {
  methods: {
    postApi(endPoint = this.modulePage, data = {}) {
      // const timestamp = Math.floor(Date.now() / 1000).toString();
      // const encryptedApiKey = CryptoJS.AES.encrypt(
      //   this.staticKey,
      //   timestamp
      // ).toString();
      // const apiKey = encryptedApiKey;
      const token = localStorage.getItem("token");
      const headers = {
        // "X-API-SECRET-STAMP": timestamp,
        // "X-API-KEY": apiKey,
        Authorization: `Bearer ${token}`,
      };
      return axios.post(`${this.apiUrl}/${endPoint}`, data, { headers });
    },
    getApi(endPoint = this.modulePage) {
      // const timestamp = Math.floor(Date.now() / 1000).toString();
      // const encryptedApiKey = CryptoJS.AES.encrypt(
      //   this.staticKey,
      //   timestamp
      // ).toString();
      // const apiKey = encryptedApiKey;
      const token = localStorage.getItem("token");
      const headers = {
        // "X-API-SECRET-STAMP": timestamp,
        // "X-API-KEY": apiKey,
        Authorization: `Bearer ${token}`,
      };
      return axios.get(`${this.apiUrl}/${endPoint}`, { headers });
    },
  },
  computed: {
    modulePage() {
      return this.$route.meta.menu;
    },
    apiUrl() {
      return process.env.VUE_APP_API_URL;
    },
    staticKey() {
      return process.env.VUE_APP_STATIC_KEY;
    },
  },
};
</script>
