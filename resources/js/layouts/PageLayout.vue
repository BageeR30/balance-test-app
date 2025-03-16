<template>
    <Head :title="title" />

    <AppLayout>
        <el-space direction="vertical" fill>
            <slot />
        </el-space>
    </AppLayout>
</template>

<script setup>
    import {Head} from "@inertiajs/vue3";
    import AppLayout from "@/layouts/AppLayout.vue";

    defineProps({
        title: String,
    });
</script>
