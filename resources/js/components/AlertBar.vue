<template>
    <div :class="style" class="flex-1 p-3 text-lg rounded">
        <span>{{ text }}</span>
    </div>
</template>

<script>
export default {
    name: "AlertBar",
    props: {
        text: {
            type: String,
            default: "API error, please try again later :("
        },
        type: {
            type: String,
            default: "danger"
        }
    },
    computed: {
        style() {
            switch (this.type) {
                case 'danger': return "bg-red"
                case 'warn': return "bg-orange text-black"
                case 'success': return "bg-green"
                default: return "bg-red";
            }
        }
    }
}
</script>
