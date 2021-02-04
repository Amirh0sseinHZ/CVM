<template>
    <div>
        <the-reservation-details v-if="hasActiveReservation"></the-reservation-details>
        <the-book-reservation v-else></the-book-reservation>
    </div>
</template>

<script>
import TheBookReservation from '../components/TheBookReservation';
import TheReservationDetails from '../components/TheReservationDetails';

export default {
    data() {
        return {
            hasActiveReservation: false
        };
    },
    components: {
        TheBookReservation,
        TheReservationDetails
    }
}
</script>
