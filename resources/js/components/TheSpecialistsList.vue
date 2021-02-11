<template>
    <div class="flex flex-col">
        <alert-bar v-if="error"></alert-bar>
        <div
            v-for="(specialist, index) in specialists"
            class="bg-white flex justify-between items-center border-b-4 text-blue-dark rounded-md p-5 mb-5"
            :class="'border-' + statusColor(specialist.awaiting)"
            v-on:click="select(index)">
                <span class="text-lg font-bold mr-3">{{ specialist.name }}</span>
                <div
                    class="relative borders border-2 border-gray outline-red rounded-full w-6 h-6"
                    :class="{'bg-blue-lighter': specialist.selected}">
                </div>
        </div>
    </div>
</template>

<script>
    import axios from "@/services/axios"
    import AlertBar from "./AlertBar";

    export default {
    components: {AlertBar},
    data() {
        return {
            specialists: [],
            error: false
        }
    },
    created() {
        axios.get("/api/v1/specialists").then(r => {
            this.specialists = r.data.map(specialist => {
                return {...specialist, selected: false}
            });
        }).catch(() => this.error = true);
    },
    methods: {
        select(index) {
            this.specialists.forEach(el => {
                el.selected = false;
            })
            this.specialists[index].selected = true;
            this.$emit('click', this.specialists[index].id);
        },
        statusColor(n) {
            if (n <= 1) return 'green';
            else if (n < 5) return 'yellow';
            else if (n < 10) return 'orange';
            else if (n >= 10) return 'red';
        }
    }
}
</script>

<style scoped>
.borders:before {
    content: " ";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 2px solid #ffffff;
    width: 100%;
    height: 100%;
    border-radius: 50%;
}
</style>
