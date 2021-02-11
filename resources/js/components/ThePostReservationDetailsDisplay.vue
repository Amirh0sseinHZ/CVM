<template>
    <div class="w-full">
        <div :class="className" class="p-6 rounded">
            <div class="text-center mb-5">
                <span class="text-5xl font-bold">{{ code }}</span>
            </div>
            <div class="flex text-black text-xl">
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
