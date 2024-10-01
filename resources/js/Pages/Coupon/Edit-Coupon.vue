<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import CouponForm from "@/Views/Coupon/Form.vue";
import { TPageDetails, TPageProps } from "@/Types/type";
import { useToast } from "primevue/usetoast";
import { convertDateFormat } from "@/Composables/useDateFormat";

const toast = useToast();

const { coupon, stores } = usePage().props as TPageProps

const page = <TPageDetails>{
    pageTitle: "Edit Coupon",
    formTitle: "Coupon Information",
    path: "coupon.index",
};

const form = useForm({
    store_id: coupon.data.store.id || "",
    name: coupon.data.name || "",
    date_start: coupon.data.date_start || "",
    date_end: coupon.data.date_end || "",
    coupon_rewards: coupon.data.coupon_rewards.slice().sort((a, b) => a.sort - b.sort) || []
});

const dateFormat = () => {
    form.date_start = convertDateFormat(form.date_start);
    form.date_end = convertDateFormat(form.date_end);
};

const submit = () => {
    dateFormat();
    const id = coupon.data.id;
    form.put(route("coupon.update", id), {
        onSuccess: () => {
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Coupon updated successfully",
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
