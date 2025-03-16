<template>
    <Head :title="title" />

    <AppLayout>
        <el-card class="card" shadow="never">
            <slot />
        </el-card>
    </AppLayout>
</template>

<script setup>
    import {Head} from "@inertiajs/vue3";
    import AppLayout from "@/layouts/AppLayout.vue";

    defineProps({
        title: String,
    });
</script>

<style scoped>
    .card {
        margin: 10px;
        height: 100%;

        * {
            margin-bottom: 10px;
        }
    }
</style>
