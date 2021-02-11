<template>
    <div class="w-full">
        <alert-bar v-if="error"></alert-bar>
        <div v-else-if="reservation">
            <the-reservation-queue-display :reservation="reservation" v-if="status === 0"
                                           v-on:cancel-reservation="cancel">
            </the-reservation-queue-display>
            <the-reservation-handling-display :reservation="reservation.reservation" v-if="status === 1">
            </the-reservation-handling-display>
            <the-post-reservation-details-display :reservation="reservation.reservation"
                                                  v-if="[-1, 2].includes(status)">
            </the-post-reservation-details-display>
        </div>
    </div>
</template>

<script>
    import axios from "@/services/axios"
    import TheReservationQueueDisplay from "../components/TheReservationQueueDisplay";
    import TheReservationHandlingDisplay from "../components/TheReservationHandlingDisplay";
    import ThePostReservationDetailsDisplay from "../components/ThePostReservationDetailsDisplay";
    import AlertBar from "../components/AlertBar";
    import {notify} from "../utils/helpers";

    export default {
        components: {
            AlertBar,
            ThePostReservationDetailsDisplay,
            TheReservationHandlingDisplay,
            TheReservationQueueDisplay
        },
        data() {
            return {
                error: false,
                reservation: '',
                status: '',
                timer: '',
                timeout: ''
            }
        },
        created() {
            this.fetchReservation().then(() => {
                this.timer = setInterval(this.fetchReservation, this.timeout)
            }).catch(() => this.$router.push({name: 'e404'}));
        },
        methods: {
            async fetchReservation() {
                await axios.get('/api/v1/reservations/' + this.$route.params.code).then(r => {
                    this.error = false
                    this.reservation = r.data
                    this.status = r.data.reservation.status
                    this.timeout = r.data.reservation.status === 0 ? 5000 : 30000
                }).catch(() => this.error = true);
            },
            cancel() {
                axios.put('/api/v1/reservations/' + this.$route.params.code + '/cancel').then(r => {
                    this.status = r.data.status
                }).catch(() => {
                    notify('An error occurred while canceling the reservation. Please try again.',
                        'error',
                        'Something Went Wrong'
                    );
                });
            }
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>

<style scoped>

</style>
