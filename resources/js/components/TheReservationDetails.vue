<template>
    <div>
        <h1>Your Reservation code is: {{ reservation.reservation.code }}</h1>
        <p>{{ timeRemaining }}</p>
    </div>
</template>

<script>
export default {
    props: {
        reservation: Object
    },
    data() {
        return {
            countDown: this.reservation.estimatedWaitingTime,
            timeRemaining: ''
        }
    },
    created() {
        this.countDownTimer()
    },
    watch: {
        reservation: function(newVal, oldVal) {
            this.countDown = newVal.estimatedWaitingTime
        }
    },
    methods: {
        countDownTimer() {
            if(this.countDown > 0) {
                setTimeout(() => {
                    this.countDown -= 1
                    this.countDownTimer()
                    this.timeRemaining = this.secondsToHms(this.countDown)
                }, 1000)
            }
        },
        secondsToHms(d) {
            d = Number(d);
            const h = Math.floor(d / 3600);
            const m = Math.floor(d % 3600 / 60);
            const s = Math.floor(d % 3600 % 60);

            const hDisplay = h > 0 ? h + (h === 1 ? " hour, " : " hours, ") : "";
            const mDisplay = m > 0 ? m + (m === 1 ? " minute, " : " minutes, ") : "";
            const sDisplay = s > 0 ? s + (s === 1 ? " second" : " seconds") : "";
            return hDisplay + mDisplay + sDisplay;
        }

    }
}
</script>
