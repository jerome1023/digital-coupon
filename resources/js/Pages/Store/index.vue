<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";
import { TPageProps, TTable } from "@/Types/type";
import { onMounted } from "vue";

const { stores, auth } = usePage().props as TPageProps;

const table: TTable = {
    columns: [
        { field: "name", header: "Name" },
        { field: "address", header: "Address" },
    ],
    contents: stores.data,
    actions: [],
};

onMounted(() => {
    table.actions = auth.user.data.role.name === "admin"
        ? [
            {
                label: "Edit",
                icon: "pi pi-pencil",
                severity: "primary",
            },
            {
                label: "Delete",
                icon: "pi pi-trash",
                severity: "danger",
            },
        ]
        : [];

    if (auth.user.data.role.name !== "store_owner") {
        table.columns.push({
            field: (rowData: any) =>
                `${rowData.owner.first_name} ${rowData.owner.last_name}`,
            header: "Owner",
        });
    }
});
</script>

<template>
    <Head title="Store" />
    <DataTable :table="table">
        <template #nav>
            <div class="flex justify-between items-center">
                <h2
                    class="font-semibold text-lg md:text-xl text-gray-800 leading-tight"
                >
                    Store
                </h2>
                <Button
                    v-if="auth.user.data.role.name === 'admin'"
                    @click="$inertia.visit('store/create')"
                    icon="pi pi-cart-plus"
                    severity="success"
                    label="Add"
                    size="small"
                />
            </div>
        </template>
    </DataTable>
</template>
