<template>
    <div class="flex flex-wrap">
        <div
            v-on:click="select(index)"
            :class="{selected: specialist.selected}"
            v-for="(specialist, index) in specialists"
            class="specialist relative select-none outline-none border-solid border-2 border-white rounded-bl-2xl rounded-tr-2xl flex items-center justify-center py-10 my-2 cursor-pointer">
            <span>{{specialist.name}}</span>
            <div :style="'background-color:' + statusColor(specialist.awaiting)" class="absolute bottom-2 right-2 w-2 h-2 rounded-full"></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            specialists: [
                {
                    id: 1,
                    name: 'Jon Doe',
                    awaiting: 6,
                    selected: false
                },
                {
                    id: 2,
                    name: 'Foo Bar',
                    awaiting: 0,
                    selected: false
                },
                {
                    id: 3,
                    name: 'Alice Brown',
                    awaiting: 3,
                    selected: false
                },
                {
                    id: 4,
                    name: 'Bob Young',
                    awaiting: 15,
                    selected: false
                }
            ]
        }
    },
    methods: {
        select(index) {
            this.specialists.forEach(el => {
                el.selected = false;
            })
            this.specialists[index].selected = true;
        },
        statusColor(n) {
            if (n <= 0) return 'green';
            else if (n < 5) return 'yellow';
            else if (n < 10) return 'orange';
            else if (n >= 10) return 'red';
        }
    }
}
</script>

<style scoped>
.specialist {
    flex: 1 0 34%;
    -webkit-tap-highlight-color:  rgba(255, 255, 255, 0);
}
.specialist.selected {
    border-color: #ffe593;
    pointer-events: none;
}
.specialist:nth-child(even) {
    margin-left: 10px;
}
</style>
