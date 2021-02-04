import Vue from 'vue';
import Router from 'vue-router'

Vue.use(Router);

import Home from './pages/Home'

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/login",
        name: "Login",
        component: () =>
            import(/* webpackChunkName: "login" */ "./pages/Login")
    },
];

export default new Router({
    mode: 'history',
    routes,
    linkExactActiveClass: 'active',
});
