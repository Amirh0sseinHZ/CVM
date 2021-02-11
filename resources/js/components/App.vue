<template>
    <div class="flex flex-col">
        <the-topbar></the-topbar>
        <main class="mt-24 flex-1 flex justify-center items-center md:mt-28">
            <div class="w-3/4 flex justify-center md:w-1/2 xl:w-1/3">
                <router-view></router-view>
            </div>
        </main>
        <notifications group="auth" position="bottom center" />
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
