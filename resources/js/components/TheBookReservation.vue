<template>
    <div class="px-20 flex flex-col align-middle">
        <the-specialists-list v-if="showSpecialists"></the-specialists-list>
        <button v-on:click="book" class="select-none my-10 draw-border cursor-pointer py-6 px-12 text-xl tracking-wide">Book an Appointment</button>
    </div>
</template>

<script>
import TheSpecialistsList from "./TheSpecialistsList";

export default {
    components: {
        TheSpecialistsList
    },
    data() {
        return {
            showSpecialists: false
        }
    },
    methods: {
        book() {
            if(this.showSpecialists) {
                //Todo: submitting
                return;
            }
            this.showSpecialists = true;
        }
    }
}
</script>

<style scoped>
.draw-border {
    box-shadow: inset 0 0 0 4px #1C91DA;
    color: #1C91DA;
    transition: color 0.25s 0.0833333333s;
    position: relative;
}
.draw-border::before, .draw-border::after {
    border: 0 solid transparent;
    box-sizing: border-box;
    content: "";
    pointer-events: none;
    position: absolute;
    width: 0;
    height: 0;
    bottom: 0;
    right: 0;
}
.draw-border::before {
    border-bottom-width: 4px;
    border-left-width: 4px;
}
.draw-border::after {
    border-top-width: 4px;
    border-right-width: 4px;
}
.draw-border:hover {
    color: #ffe593;
}
.draw-border:hover::before, .draw-border:hover::after {
    border-color: #ffe593;
    transition: border-color 0s, width 0.25s, height 0.25s;
    width: 100%;
    height: 100%;
}
.draw-border:hover::before {
    transition-delay: 0s, 0s, 0.25s;
}
.draw-border:hover::after {
    transition-delay: 0s, 0.25s, 0s;
}
</style>
