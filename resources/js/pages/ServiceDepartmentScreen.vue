<template>
    <div class="w-full">
        <h1 class="page-title">Service Department Screen</h1>
        <div v-if="reservations.handling || reservations.waiting" class="flex flex-col">
            <div v-if="reservations.handling" class="mb-5">
                <h2 class="text-xl mb-4">Current Sessions</h2>
                <div v-for="reservation in reservations.handling"
                     class="bg-white flex justify-between items-center rounded-md text-gray-dark py-3 px-5 mb-3 text-lg font-extrabold">
                    <span>{{ reservation.specialist_id + '-' + reservation.id }}</span>
                    <div class="blink w-4 h-4 bg-green rounded-full"></div>
                </div>
            </div>
            <div v-if="reservations.waiting">
                <h2 class="text-xl mb-4">Upcoming Reservations</h2>
                <div class="flex flex-col">
                    <div
                        v-for="reservation in reservations.waiting"
                        class="bg-white flex justify-between items-center rounded-md text-gray-dark py-3 px-5 mb-3 text-lg font-extrabold">
                        <span>{{ reservation.specialist_id + '-' + reservation.id }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <alert-bar v-if="error"></alert-bar>
            <alert-bar v-else type="info" text="There is no reservations at this moment"></alert-bar>
        </div>
    </div>
</template>

<script>
    import axios from "@/services/axios"
    import AlertBar from "../components/AlertBar";

    export default {
        components: {AlertBar},
        data() {
            return {
                reservations: {
                    handling: null,
                    waiting: null
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
                axios.get('api/v1/reservations').then(r => {
                    this.reservations = r.data;
                    this.error = false;
                }).catch(() => this.error = true);
            }
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }

</script>

<style scoped>
    .blink {
        animation: blinker 0.7s linear infinite;
    }

    @keyframes blinker {
        0% {
            opacity: .25
        }
        50% {
            opacity: 1;
        }
        100% {
            opacity: .25;
        }
    }
</style>
