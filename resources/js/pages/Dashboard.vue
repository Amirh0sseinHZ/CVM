<template>
    <div class="w-full">
        <p class="page-title">Welcome back, <span class="font-extrabold">{{ User.name }}</span></p>
        <div v-if="reservations.handling || reservations.waiting.length > 0">
            <the-customer-visit-management :reservations="reservations"></the-customer-visit-management>
        </div>
        <div v-else>
            <alert-bar v-if="!error" type="info" text="There is no reservations at this moment"></alert-bar>
            <alert-bar v-else></alert-bar>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import TheCustomerVisitManagement from "../components/TheCustomerVisitManagement";
    import AlertBar from "../components/AlertBar";
    import axios from "@/services/axios";

    export default {
        components: {
            TheCustomerVisitManagement,
            AlertBar
        },
        computed: {
            ...mapGetters({User: 'stateUser'}),
        },
        data() {
            return {
                reservations: {
                    handling: null,
                    waiting: []
                },
                error: false,
                timer: ''
            }
        },
        created() {
            this.fetchReservations();
            this.timer = setInterval(this.fetchReservations, 5 * 1000)
        },
        methods: {
            fetchReservations() {
                axios.get('api/v1/specialists/' + this.User.id).then(r => {
                    this.reservations = r.data.reservations;
                    this.error = false;
                }).catch(() => this.error = true);
            }
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>
