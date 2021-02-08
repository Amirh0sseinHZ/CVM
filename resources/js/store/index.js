import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from './modules/auth'
import reservations from "./modules/reservations";

Vue.use(Vuex)

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth: auth,
        reservations: reservations
    },
    plugins: [createPersistedState()]
})
