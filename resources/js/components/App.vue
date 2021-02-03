<template>
    <div class="flex flex-col">
        <header class="fixed bg-blue-light top-0 w-full h-20">
            <the-navigation></the-navigation>
        </header>
        <main class="mt-20 flex-1 flex justify-center items-center">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import TheNavigation from "./TheNavigation";

export default {
    components: {
        TheNavigation
    }
}
</script>
