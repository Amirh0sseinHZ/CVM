<template>
    <div class="w-full">
        <h1 class="page-title">Book Reservation</h1>
        <h2 class="text-lg mb-3">Select the specialist</h2>
        <the-specialists-list v-on:click="select"></the-specialists-list>
        <button
            v-on:click="book"
            class="bg-blue-light rounded p-4 mt-2 select-none cursor-pointer text-xl tracking-wide hover:bg-blue-lighter">
            Book an Appointment
        </button>
    </div>
</template>

<script>
    import axios from "@/services/axios";
    import TheSpecialistsList from "../components/TheSpecialistsList";
    import {notify} from "../utils/helpers";

    export default {
    components: {
        TheSpecialistsList
    },
    data() {
        return {
            selectedSpecialistId: null
        }
    },
    methods: {
        select(id) {
            this.selectedSpecialistId = id;
        },
        book() {
            if(!this.selectedSpecialistId) {
                return;
            }
            const payload = {
                specialist_id: this.selectedSpecialistId
            }
            axios.post("/api/v1/reservations", payload).then(r => {
                notify('Your reservation was successfully booked.',
                    'success', 'Booking Successful')
                const code = r.data.specialist_id + '-' + r.data.id
                this.$router.push({ name: 'Reservations', params: { code: code }})
            }).catch(() =>{
                notify('Something went wrong while trying to book your reservation. Please try again later',
                'error', 'Booking Failed')
            });
        }
    }
}
</script>
