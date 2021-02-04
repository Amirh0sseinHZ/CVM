<template>
    <header class="fixed top-0 w-full h-24 flex flex-row justify-between items-center px-12">
        <div>
            <svg width="30" height="30" class="rounded-xl"
                 xmlns="http://www.w3.org/2000/svg">
                <image :href="'./img/nfq-logo.svg'" width="30" height="30"/>
            </svg>
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
