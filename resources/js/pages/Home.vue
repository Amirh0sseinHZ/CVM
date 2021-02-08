<template>
    <div>
        <the-reservation-details
            v-if="hasActiveReservation"
            :reservation="activeReservation"
        ></the-reservation-details>
<!--        <div v-if="hasActiveReservation">{{activeReservation}}</div>-->
        <the-book-reservation v-else></the-book-reservation>
    </div>
</template>

<script>
    import TheBookReservation from '../components/TheBookReservation';
    import TheReservationDetails from '../components/TheReservationDetails';

    export default {
    created() {
        this.$store.dispatch('checkForActiveReservation')
    },
    components: {
        TheBookReservation,
        TheReservationDetails
    },
    computed: {
        hasActiveReservation: function() {
            return this.$store.getters.hasActiveReservation
        },
        activeReservation: function() {
            return this.$store.getters.getTheReservation
        }
    },
}
</script>
