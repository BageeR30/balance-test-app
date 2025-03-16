<template>
    <Head title="History" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <el-card class="card" shadow="never">
            <el-card shadow="never">
                <el-input v-model="search" placeholder="Search" @input="handleSearch()" />

                <el-table
                    :data="items.data"
                    border
                    :max-height="500"
                    @sort-change="handleSort"
                >
                    <el-table-column prop="id" label="ID"/>
                    <el-table-column prop="status" label="Status" />
                    <el-table-column prop="amount" label="Amount" />
                    <el-table-column prop="description" label="Description" />
                    <el-table-column prop="created_at" label="Created at" sortable="custom" />
                    <el-table-column prop="updated_at" label="Updated at" sortable="custom" />
                </el-table>

                <el-pagination
                    class="pull-right"
                    layout="sizes, prev, pager, next"
                    :total="items.total"
                    v-model:page-size="perPage"
                    @change="handleChange"
                />
            </el-card>
        </el-card>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/layouts/AppLayout.vue';
    import {Head, router} from '@inertiajs/vue3';
    import {ref} from "vue";
    import _ from 'lodash';

    const breadcrumbs = [
        {
            title: 'History',
            href: '/history',
        },
    ];

    const props = defineProps({
        items: Object,
    });

    const perPage = ref(props.items.per_page);
    const search = ref('');

    const handleChange = (page, pageSize) => {
        router.reload({data: {page, per_page: pageSize}});
    }

    const handleSort = column => {
        router.reload({data: {sort: column.prop, order: column.order}});
    }

    const handleSearch = _.debounce(() => {
        router.reload({data: {search: search.value}});
    },600)

</script>

<style scoped>
    .card {
        margin: 10px;
        height: 100%;

        * {
            margin-bottom: 10px;
        }
    }

    .pull-right {
        float: right;
    }
</style>
