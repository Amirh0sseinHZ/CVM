require('./bootstrap');

import Vue from 'vue';
import router from './router';

Vue.component(
    'App',
    require('./components/App.vue').default
);

const app = new Vue({
    el: '#app',
    router
});
