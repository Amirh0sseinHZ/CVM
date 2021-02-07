<template>
    <div v-if="!isLoggedIn" class="text-xl select-none outline-none">
        <router-link class="router-link" :to="{ name: 'Home' }">Home</router-link>
        <router-link class="router-link" :to="{ name: 'Login' }">Login</router-link>
    </div>
    <div v-else class="text-xl select-none outline-none">
        <router-link class="router-link" :to="{ name: 'Dashboard' }">Dashboard</router-link>
        <a @click="logout" class="router-link router-link-active">Logout</a>
    </div>
</template>

<script>
export default {
    computed: {
        isLoggedIn: function() {return this.$store.getters.isLoggedIn}
    },
    methods: {
        logout() {
            this.$store.dispatch('logout').then(() => {
                this.$router.push({ name: 'Login'});
            });
        }
    }
}
</script>
