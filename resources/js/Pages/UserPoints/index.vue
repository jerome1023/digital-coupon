<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { TPageProps } from "@/Types/type";
import { usePage } from "@inertiajs/vue3";
const { points } = usePage().props as TPageProps;
</script>
<template>
    <AuthenticatedLayout>
        <!-- <div
            class="max-w-sm h-96 mx-auto p-4 sm:px-6 lg:px-8 space-y-6 text-center bg-white rounded-lg"
        >
            <div
                class="mx-auto bg-yellow-400 w-20 h-20 rounded-full flex items-center justify-center"
            >
                <i class="pi pi-star-fill text-4xl text-yellow-600"></i>
            </div>
            <p class="text-xl font-semibold bg-yellow-400 rounded-md">
                {{ points }} Points
            </p>
        </div> -->

        <div
            class="max-w-sm h-72 mx-auto p-4 sm:px-6 lg:px-8 space-y-6 text-center bg-white rounded-lg flex flex-col items-center justify-center"
        >
            <div
                class="bg-yellow-400 w-20 h-20 rounded-full flex items-center justify-center"
            >
                <i class="pi pi-star-fill text-4xl text-yellow-600"></i>
            </div>
            <p class="text-xl font-semibold bg-yellow-400 rounded-md px-5">
                {{ points }} Points
            </p>
        </div>
    </AuthenticatedLayout>
</template>
