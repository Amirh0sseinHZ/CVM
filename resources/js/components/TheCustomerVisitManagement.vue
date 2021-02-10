<template>
    <div class="flex flex-col">
        <div v-if="reservations.handling" class="mb-5 border-b-2 border-blue border-white pb-5">
            <h2 class="text-xl mb-4">Active Session</h2>
            <div class="flex justify-between p-5 items-center w-full bg-white rounded-lg text-blue-dark">
                <h3 class="text-4xl font-extrabold">
                    {{ getCode(reservations.handling) }}
                </h3>
                <base-btn
                    v-on:click="end(reservations.handling)"
                    text="End Session" class="bg-red font-bold">
                </base-btn>
            </div>
        </div>
        <div v-if="reservations.waiting && reservations.waiting.length > 0">
            <h2 class="text-xl mb-4">Incoming</h2>
            <div>
                <div v-for="reservation in reservations.waiting"
                     class="flex justify-between items-center bg-white rounded-lg text-gray-dark p-2 px-5 mb-3">
                    <h3 class="text-xl">
                        {{ getCode(reservation) }}
                    </h3>
                    <div class="border-l-2 border-gray-light pl-4">
                        <base-btn
                            v-on:click="accept(reservation)"
                            :class="disabled"
                            text="accept" class="bg-green">
                        </base-btn>
                        <base-btn
                            v-on:click="cancel(reservation)"
                            text="cancel" class="bg-gray">
                        </base-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BaseBtn from "./BaseBtn";
    import {notify} from "../utils/helpers";
    import axios from "@/services/axios";

    export default {
        components: {BaseBtn},
        props: {
            reservations: Object
        },
        computed: {
            disabled: function () {
                return this.reservations.handling ? 'opacity-75 cursor-not-allowed' : '';
            }
        },
        methods: {
            accept(reservation) {
                if (this.reservations.handling) { // if there's an active session at the moment, we'll stop allowing
                    // the user to attempt to make another session active
                    return notify("You can't accept another reservation while you have an active session." +
                        " To continue, please first finish your current session.", 'error', 'Conflict');
                }
                this.apiCall(reservation, 'handle').then(() => {
                    this.reservations.handling = reservation;
                    this.reservations.waiting = this.reservations.waiting.filter(r => r.id !== reservation.id);
                })
            },
            cancel(reservation) {
                this.apiCall(reservation, 'cancel').then(() => {
                    this.reservations.waiting = this.reservations.waiting.filter(r => r.id !== reservation.id);
                })
            },
            end(reservation) {
                this.apiCall(reservation, 'end').then(() => {
                    this.reservations.handling = null
                    notify("The session was successfully ended.", 'success', 'Successful Operation')
                })
            },
            apiCall(reservation, action) {
                return axios.put('/api/v1/reservations/' + this.getCode(reservation) + `/${action}`)
                    .catch(() => notify("Something went wrong while trying to update the state of the " +
                        "reservation. Please refresh the page.", 'error', 'Update Error'))
            },
            getCode(reservation) {
                return reservation.specialist_id + '-' + reservation.id;
            }
        }
    }
</script>
