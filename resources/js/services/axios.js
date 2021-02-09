import axios from "axios";
import store from "@/store";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.response.use( response => {
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

export default axios;
