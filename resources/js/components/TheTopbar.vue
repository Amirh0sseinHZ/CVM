<template>
    <header class="bg-blue-dark z-50 fixed top-0 w-full h-24 flex flex-row justify-between items-center px-12 md:px-16 md:h-28">
        <div>
            <router-link :to="{ name: 'Home'}">
                <svg width="30" height="30" class="rounded-xl" xmlns="http://www.w3.org/2000/svg">
                    <image href="/img/nfq-logo.svg" width="30" height="30"/>
                </svg>
            </router-link>
        </div>
        <the-navigation></the-navigation>
    </header>
</template>

<script>
    import TheNavigation from "./TheNavigation";

    export default {
    components: {
        TheNavigation
    }
}
</script>
