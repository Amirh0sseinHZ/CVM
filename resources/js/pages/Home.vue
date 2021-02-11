<template>
    <div class="w-full flex flex-col">
        <div class="mb-5">
            <the-search></the-search>
        </div>
        <div>
            <router-link :to="{name: 'BookReservation'}" class="text-gray text-lg hover:text-gray-light sm:text-xl xl:text-2xl">
                or book a <span class="underline">new reservation</span> now!
            </router-link>
        </div>
    </div>
</template>

<script>
    import TheSearch from '../components/TheSearch'

    export default {
        components: {TheSearch}
    }
</script>
