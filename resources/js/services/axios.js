import axios from "axios";
import store from "@/store";

const axiosInstance = axios.create({
  baseURL: process.env.MIX_API_URL,
  withCredentials: true,
});

axiosInstance.interceptors.response.use( response => {
        return response;
    },
    function(error) {
        if(error.response && (error.response.status === 401 || error.response.status === 419)) {
            store.dispatch('logout')
            return this.$router.push({ name: 'Login'});
        }
        return Promise.reject(error);
    }
);

export default axiosInstance;
