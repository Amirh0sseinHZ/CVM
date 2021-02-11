<template>
    <div class="w-full">
        <div v-if="reservation">
            <the-reservation-queue-display :reservation="reservation" v-if="status === 0">
            </the-reservation-queue-display>
            <the-reservation-handling-display :reservation="reservation.reservation" v-if="status === 1">
            </the-reservation-handling-display>
            <the-post-reservation-details-display :reservation="reservation.reservation" v-if="[-1, 2].includes(status)">
            </the-post-reservation-details-display>
        </div>
    </div>
</template>

<script>
    import axios from "@/services/axios"
    import TheReservationQueueDisplay from "../components/TheReservationQueueDisplay";
    import TheReservationHandlingDisplay from "../components/TheReservationHandlingDisplay";
    import ThePostReservationDetailsDisplay from "../components/ThePostReservationDetailsDisplay";

    export default {
        components: {ThePostReservationDetailsDisplay, TheReservationHandlingDisplay, TheReservationQueueDisplay},
        data() {
            return {
                reservation: '',
                status: '',
                timer: ''
            }
        },
        created() {
            this.fetchReservation().catch(() => this.$router.push({name: 'e404'}));
            this.timer = setInterval(this.fetchReservation, 5 * 1000) // TODO: dynamic timeout
        },
        methods: {
            async fetchReservation() {
                await axios.get('/api/v1/reservations/' + this.$route.params.code).then(r => {
                    this.reservation = r.data
                    this.status = r.data.reservation.status
                });
            },
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>

<style scoped>

</style>
