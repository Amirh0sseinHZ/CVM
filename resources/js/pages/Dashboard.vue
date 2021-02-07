<template>
    <div>
        <h1>Welcome back, {{User.name}}</h1>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
    computed: {
        ...mapGetters({User: 'stateUser'}),
    }
}
</script>
