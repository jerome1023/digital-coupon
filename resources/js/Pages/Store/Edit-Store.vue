<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import StoreForm from "@/Views/Store/Form.vue";
import { TPageDetails, TPageProps } from "@/Types/type";
import { useToast } from "primevue/usetoast";

const toast = useToast();

const { store, owners } = usePage().props as TPageProps


const page = <TPageDetails>{
    pageTitle: "Edit Store",
    formTitle: "Store Information",
    path: "store.index",
};

const form = useForm({
    owner_id: store.data.owner.id || "",
    name: store.data.name || "",
    address: store.data.address || "",
});

const submit = () => {
    const id = store.data.id;
    form.put(route("store.update", id), {
        onSuccess: () => {
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Store updated successfully",
                life: 3000,
            });
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <StoreForm :form="form" :page="page" :options="owners.data" />
    </form>
</template>
