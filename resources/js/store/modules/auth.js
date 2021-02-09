import axios from "@/services/axios";
import {getError} from "../../utils/helpers";

export default {
    state: {
        status: localStorage.getItem('authStatus') || '',
        user: ''
    },
    mutations: {
        login_success(state, user) {
            localStorage.setItem('authStatus', 1)
            state.status = true
            state.user = user
        },
        logout_success(state) {
            localStorage.removeItem('authStatus')
            state.status = ''
            state.user = ''
        }
    },
    actions: {
        login({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .get('/sanctum/csrf-cookie')
                    .then(() => {return axios.post("/login", payload)})
                    .then(() => {return axios.get("/api/v1/user")})
                    .then(response => {
                        commit('login_success', response.data)
                        resolve()
                    }).catch(e => {reject(getError(e))});
            });
        },
        logout({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('/sanctum/csrf-cookie')
                    .then(() => axios.post("/logout"))
                    .then(() => {
                        commit("logout_success");
                        resolve();
                    }).catch(() => {reject()});
            });
        }
    },
    getters: {
        isLoggedIn: state => !!state.status,
        stateUser: state => state.user
    }
}
