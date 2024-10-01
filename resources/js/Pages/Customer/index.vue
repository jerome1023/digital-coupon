<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";
import { TPageProps, TTable } from "@/Types/type";

const { customers } = usePage().props as TPageProps;

const table: TTable = {
    columns: [
        { field: "first_name", header: "Firstname" },
        { field: "last_name", header: "Lastname" },
    ],
    contents: customers.data,
    actions: [],
};
</script>

<template>
    <Head title="Store Owner" />
    <DataTable :table="table">
        <template #nav>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-lg md:text-xl text-gray-800 leading-tight">
                    My Customer
                </h2>
                <!-- <Button @click="$inertia.visit('owner/create')" icon="pi pi-user-plus" severity="success" label="Add" size="small"/> -->
            </div>
        </template>
    </DataTable>
</template>
