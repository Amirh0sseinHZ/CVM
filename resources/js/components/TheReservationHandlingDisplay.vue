<template>
    <div class="w-full">
        <div class="flex flex-col items-center justify-center">
            <span class="text-white text-8xl font-bold mb-5">{{ code }}</span>
            <p class="flex items-center text-2xl">
                Yaaaay <span class="text-6xl px-2">🥳</span>, It's your turn now!
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: { reservation: Object },
        computed: {
            code: function () {
                return this.reservation.specialist_id + '-' + this.reservation.id
            }
        }
    }
</script>
