<template>
    <div>
        <the-book-reservation></the-book-reservation>
    </div>
</template>

<script>
    import TheBookReservation from '../components/TheBookReservation';

    export default {
    created() {
        this.$store.dispatch('checkForActiveReservation')
    },
    components: {
        TheBookReservation
    }
}
</script>
