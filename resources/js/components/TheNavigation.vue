<template>
    <div class="text-xl select-none outline-none text-gray">
        <div v-if="!isLoggedIn">
            <router-link class="router-link" :to="{ name: 'Home' }">Home</router-link>
            <router-link class="router-link" :to="{ name: 'Login' }">Login</router-link>
        </div>
        <div v-else>
            <router-link class="router-link" :to="{ name: 'SDS' }">SDS</router-link>
            <router-link class="router-link" :to="{ name: 'Dashboard' }">Dashboard</router-link>
            <a @click="logout" class="router-link router-link-active">Logout</a>
        </div>
    </div>
</template>

<script>
    import {notify} from "../utils/helpers";

    export default {
    computed: {
        isLoggedIn: function() {return this.$store.getters.isLoggedIn}
    },
    methods: {
        logout() {
            this.$store.dispatch('logout').then(() => {
                this.$router.push({ name: 'Login'});
            }).catch(err => {
                notify('Failed to logout, please try again later.', 'error', 'API Error');
            });
        }
    }
}
</script>
