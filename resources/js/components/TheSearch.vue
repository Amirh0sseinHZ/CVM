<template>
    <div class="w-full">
        <div>
            <form @submit.prevent="search">
                <div class="relative">
                    <input
                        :class="style"
                        class="bg-blue w-full border-2 border-transparent pl-5 pr-20 py-4 text-2xl rounded outline-none"
                        placeholder="Reservation Code"
                        v-model="code"/>
                    <div :class="style"
                         class="absolute bg-gray border-2 border-transparent right-0 top-0 w-16 bottom-0 rounded-r flex justify-center items-center">
                        <span class="text-6xl select-none">⌕</span>
                    </div>
                </div>
            </form>
        </div>
        <div v-if="reservation" class="mt-5">
            <router-link :to="{name: 'Reservations' , params:{ code: code }}">
                <div
                    class="bg-white rounded flex justify-between items-center text-blue-dark py-2 px-5 border-b-4"
                    :class="'border-' + STATUSES[reservation.status].color">
                    <span class="text-2xl font-bold">{{ code }}</span>
                    <span :class="'text-' + STATUSES[reservation.status].color">
                        {{ STATUSES[reservation.status].state }}
                    </span>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import axios from "@/services/axios"

    const STATUSES = Object.freeze({
        '-1': {
            state: 'Canceled',
            color: 'red'
        },
        '0': {
            state: 'Waiting',
            color: 'blue-light'
        },
        '1': {
            state: 'Handling',
            color: 'orange'
        },
        '2': {
            state: 'Served',
            color: 'green'
        }
    });

    export default {
        data() {
            return {
                code: '', // v-model
                reservation: '',
                style: '',
                STATUSES
            }
        },
        watch: {
            code: function (newCode, oldCode) {
                this.style = ''
                this.reservation = ''
                this.debounced()
            }
        },
        created() {
            this.debounced = _.debounce(this.search, 500)
        },
        methods: {
            search: function () {
                if(!this.code) {
                    return;
                }

                if (!this.code.match("^([1-9]\\d{0,}-[1-9]\\d{0,})$")) {
                    this.style = 'border-red' //error
                    return
                }

                this.style = 'border-2 border-blue-light' /// thinking

                axios.get('/api/v1/reservations/' + this.code).then(r => {
                    this.reservation = r.data.reservation
                    this.style = 'border-green'
                }).catch((e) => {
                    console.log(e);
                    this.style = 'border-red'
                });
            }
        }
    }
</script>

<style scoped>

</style>
