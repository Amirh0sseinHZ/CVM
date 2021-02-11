<template>
    <div class="w-full">
        <div class="flex flex-col-reverse relative">
            <base-btn class="bg-gray hover:bg-gray-dark my-20 px-0" text="Cancel My Reservation"
                      v-on:click="cancel"></base-btn>
            <div
                v-for="(item, index) in queue.items"
                class="bg-white text-blue-dark py-5 my-5 text-center text-2xl rounded relative"
                :class="item.id === reservation.reservation.id ? 'bg-blue-lighter' : ''"
            >
                <span
                    v-if="index !== 0"
                    class="absolute top-0 text-white arrow right-0 left-0 text-4xl">
                    ↓
                </span>
                <div class="flex flex-col">
                    <span class="tracking-widest">
                        {{ item.specialist_id + '-' + item.id }}
                    </span>
                </div>
            </div>
            <p class="text-xl">
                <span><b>Your position in the queue</b> ({{ queue.position + 1 }}/{{ queue.items.length }})</span> <br/>
                <span><b>Estimated waiting time:</b> {{ countDown.hm }}</span> <br/>
                <span class="text-yellow" v-if="isSpecialistIdle">The specialist looks idle</span>
            </p>
        </div>
    </div>
</template>

<script>
    import {secondsToHm} from "../utils/helpers";
    import BaseBtn from "../components/BaseBtn";

    export default {
        components: {BaseBtn},
        props: {reservation: Object},
        data() {
            return {
                countDown: {
                    remaining: 0,
                    hm: '',
                },
                isSpecialistIdle: false
            }
        },
        created() {
            this.countDown.remaining = this.reservation.queue.estimation
            this.countDownTimer()
        },
        computed: {
            queue: function () {
                return this.reservation.queue
            }
        },
        watch: {
            queue: function (newQueue, oldQueue) {
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
            cancel() {
                this.$emit('cancel-reservation')
            }
        }
    }
</script>

<style scoped>
    .arrow {
        top: 4.35rem;
    }
</style>
