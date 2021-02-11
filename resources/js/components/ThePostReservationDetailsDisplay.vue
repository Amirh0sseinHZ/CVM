<template>
    <div class="w-full sm:w-3/5 md:2/3 xl:3/4">
        <div :class="className" class="p-6 rounded md:p-8 lg:py-16">
            <div class="text-center mb-5">
                <span class="text-5xl font-bold lg:text-6xl">{{ code }}</span>
            </div>
            <div class="flex text-black text-xl lg:text-2xl">
                <div class="flex flex-col pr-4 items-end">
                    <b>Status: </b>
                    <b>At: </b>
                </div>
                <div class="flex flex-col">
                    <span>{{ status }}</span>
                    <span>{{ at }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: { reservation: Object },
        computed: {
            code: function () {
                return this.reservation.specialist_id + '-' + this.reservation.id
            },
            className: function () {
                return this.reservation.status === 2 ? 'bg-green' : 'bg-red'
            },
            at() {
                return (new Date(this.reservation.updated_at)).toString()
            },
            status() {
                return this.reservation.status === 2 ? 'Served' : 'Canceled'
            }
        }
    }
</script>
