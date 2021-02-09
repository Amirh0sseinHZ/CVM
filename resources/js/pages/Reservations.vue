<template>
    <div class="w-full">
        <div class="flex flex-col-reverse relative">
            <base-btn class="bg-gray hover:bg-gray-dark my-20 px-0" text="Cancel My Reservation" v-on:click="cancel"></base-btn>
            <div
                v-for="item in queue.items"
                class="bg-white text-blue-dark py-5 my-5 text-center text-2xl rounded relative"
                :class="item.id === reservation.id ? 'bg-blue-lighter' : ''"
            >
                <span class="absolute top-0 text-white arrow right-0 left-0 text-4xl">↓</span>
                <div class="flex flex-col">
                    <span class="tracking-widest">
                        {{ item.specialist_id + '-' + item.id }}
                    </span>
                </div>
            </div>
            <p class="text-xl">
                <span><b>Your position in the queue</b> ({{ queue.position + 1 }}/{{ queue.items.length }})</span> <br/>
                <span><b>Estimated waiting time:</b> {{ countDown.hm }}</span> <br/>
                <span v-if="isSpecialistIdle">The specialist looks idle</span>
            </p>
        </div>
    </div>
</template>

<script>
    import axios from "@/services/axios"
    import {notify, secondsToHm} from "../utils/helpers";
    import BaseBtn from "../components/BaseBtn";

    export default {
        components: {BaseBtn},
        data() {
            return {
                reservation: {},
                queue: {
                    position: 0,
                    items: []
                },
                countDown: {
                    remaining: 0,
                    hm: '',
                    timer: ''
                },
                isSpecialistIdle: false
            }
        },
        created() {
            this.fetchReservation().then(() => this.countDownTimer())
                .catch(() => this.$router.push({name: 'e404'}));
            this.countDown.timer = setInterval(this.fetchReservation, 5 * 1000)
        },
        watch: {
            queue: function(newQueue, oldQueue) {
                this.isSpecialistIdle = newQueue.estimation === oldQueue.estimation;
            }
        },
        methods: {
            countDownTimer() {
                if (this.countDown.remaining > 0) {
                    setTimeout(() => {
                        this.countDown.remaining -= 1
                        this.countDownTimer()
                        this.countDown.hm = secondsToHm(this.countDown.remaining)
                    }, 1000)
                } else {
                    this.countDown.hm = 'soon'
                }
            },
            async fetchReservation() {
                await axios.get('/api/v1/reservations/' + this.$route.params.code).then(r => {
                    this.reservation = r.data.reservation
                    this.queue = r.data.queue
                    this.countDown.remaining = r.data.queue.estimation
                });
            },
            cancel() {
                axios.put('/api/v1/reservations/' + this.$route.params.code + '/cancel').then(() => {
                    this.$router.push({name: 'Home'});
                    notify('The reservation was successfully canceled.', 'success', 'Action Successful');
                }).catch(() => {
                    notify('An error occurred while canceling the reservation.', 'error', 'Internal Error');
                });
            }
        },
        beforeDestroy() {
            clearInterval(this.countDown.timer)
        }
    }
</script>

<style scoped>
    .arrow {
        top: 4.35rem;
    }
</style>
