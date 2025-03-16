<template>
    <page-layout title="Dashboard">
        <el-card class="card" shadow="never">
            <el-card shadow="never">
                Balance: ${{ balance }}
            </el-card>

            <el-card shadow="never">
                <div>Last transactions</div>

                <el-table :data="transactions" border>
                    <el-table-column prop="id" label="ID"/>
                    <el-table-column prop="status" label="Status" />
                    <el-table-column prop="amount" label="Amount" />
                    <el-table-column prop="description" label="Description" />
                    <el-table-column prop="created_at" label="Created at" />
                    <el-table-column prop="updated_at" label="Updated at" />
                </el-table>
            </el-card>
        </el-card>
    </page-layout>
</template>

<script setup>
    import {usePoll} from '@inertiajs/vue3';
    import PageLayout from "@/layouts/PageLayout.vue";

    defineProps({
        balance: Number,
        transactions: Array,
    });

    usePoll(5000);
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
