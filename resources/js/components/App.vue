<template>
    <div class="flex flex-col">
        <the-topbar></the-topbar>
        <main class="mt-20 flex-1 flex justify-center items-center">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import TheTopbar from "./TheTopbar";

export default {
    components: {
        TheTopbar
    }
}
</script>
