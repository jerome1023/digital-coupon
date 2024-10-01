<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import CouponForm from "@/Views/Coupon/Form.vue";
import { TPageDetails, TPageProps } from "@/Types/type";
import { useToast } from "primevue/usetoast";
import { convertDateFormat } from "@/Composables/useDateFormat";

const toast = useToast();

const { stores } = usePage().props as TPageProps;

const page = <TPageDetails>{
    pageTitle: "Add Coupon",
    formTitle: "Coupon Information",
    path: "coupon.index",
};

const form = useForm({
    store_id: "",
    name: "",
    date_start: "",
    date_end: "",
    coupon_rewards: [],
});

const dateFormat = () => {
    form.date_start = convertDateFormat(form.date_start);
    form.date_end = convertDateFormat(form.date_end);
};

const submit = () => {
    dateFormat();
    form.post(route("coupon.store", { preserveScroll: true }), {
        onSuccess: () => {
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Coupon added successfully",
                life: 3000,
            });
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <CouponForm :form="form" :page="page" :options="stores.data" />
    </form>
</template>
