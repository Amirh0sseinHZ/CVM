<template>
    <div class="w-full lg:w-3/4">
        <h1 class="page-title">Personnel Login</h1>
        <form @submit.prevent="login">
            <BaseInput
                type="email"
                label="Email"
                name="email"
                v-model="email"
                autocomplete="email"
                placeholder="admin@nfq.lt"
                class="mb-2"
                required="required"
            />
            <BaseInput
                type="password"
                label="Password"
                name="password"
                v-model="password"
                class="mb-4"
                required="required"
            />
            <div class="flex justify-between">
                <BaseBtn class="bg-blue-light" type="submit" text="Login"/>
            </div>
        </form>
    </div>
</template>

<script>
    import BaseBtn from "@/components/BaseBtn";
    import BaseInput from "@/components/BaseInput";
    import {flash} from "../utils/helpers";

    export default {
        name: "LoginView",
        components: {
            BaseBtn,
            BaseInput
        },
        data() {
            return {
                email: null,
                password: null
            };
        },
        methods: {
            login() {
                const payload = {
                    email: this.email,
                    password: this.password,
                };
                this.$store.dispatch('login', payload).then(() => {
                    this.$router.push({name: 'Dashboard'});
                }).catch(err => {
                    flash(err);
                });
            },
        },
    };
</script>
