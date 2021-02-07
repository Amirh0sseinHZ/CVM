import Vue from 'vue';
import Router from 'vue-router'
import store from "@/store/index";
import auth from "@/middleware/auth";
import guest from "@/middleware/guest";
import middlewarePipeline from "@/router/middlewarePipeline";
import Home from '../pages/Home'

Vue.use(Router);

const routes = [
    {
        path: "/",
        name: "Home",
        meta: { middleware: [guest] },
        component: Home
    },
    {
        path: "/login",
        name: "Login",
        meta: { middleware: [guest] },
        component: () =>
            import(/* webpackChunkName: "login" */ "../pages/Login")
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        meta: { middleware: [auth] },
        component: () =>
            import(/* webpackChunkName: "dashboard" */ "../pages/Dashboard")
    },
];

const router = new Router({
    mode: 'history',
    routes,
    linkExactActiveClass: 'active',
});

router.beforeEach((to, from, next) => {
    const middleware = to.meta.middleware;
    const context = { to, from, next, store };
    if (!middleware)
        return next();
    middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1),
    });
});

export default router;
