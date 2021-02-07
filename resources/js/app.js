require('./bootstrap');

import Vue from 'vue';
import router from './router';
import store from "./store";
import Notifications from 'vue-notification'

Vue.component(
    'App',
    require('./components/App.vue').default
);

Vue.use(Notifications);

const app = new Vue({
    router,
    store,
    el: '#app'
});
