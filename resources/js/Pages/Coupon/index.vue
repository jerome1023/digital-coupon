<script setup lang="ts">
import { Head, Link, usePage } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";
import { TPageProps, TTable } from "@/Types/type";
import { onMounted, ref } from "vue";

const { coupons, auth } = usePage().props as TPageProps;

const table: TTable = {
    columns: [
        { field: "store.name", header: "Store" },
        { field: "name", header: "Name" },
        { field: "date_start", header: "Date Start" },
        { field: "date_end", header: "Date End" },
    ],
    contents: coupons.data,
    actions: [],
};

onMounted(() => {
    table.actions =
        auth.user.data.role.name === "store_owner"
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
            : [
                  {
                      label: "Scan QR",
                      icon: "pi pi-qrcode",
                      severity: "contrast",
                  },
              ];
});
</script>

<template>
    <Head title="Coupon" />
    <DataTable :table="table">
        <template #nav>
            <div class="flex justify-between items-center">
                <h2
                    class="font-semibold text-lg md:text-xl text-gray-800 leading-tight"
                >
                    Coupon
                </h2>
                <Button
                    v-if="auth.user.data.role.name === 'store_owner'"
                    @click="$inertia.visit('coupon/create')"
                    icon="pi pi-ticket"
                    severity="success"
                    label="Add"
                    size="small"
                />
            </div>
        </template>
    </DataTable>
</template>
