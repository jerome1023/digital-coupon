<script setup lang="ts">
import FormContainer from "@/Components/FormContainer.vue";
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import { TPageDetails, TPageProps } from "@/Types/type";

const { my_stamps } = usePage().props as TPageProps;
const toast = useToast();
const sortedStamps = my_stamps.data.sort((a, b) => a.sort - b.sort);
const page = <TPageDetails>{
    pageTitle: "Scan Coupon",
    path: "my_coupon.index",
};
</script>

<template>
    <FormContainer :page="page">
        <!-- {{ my_stamps.data }} -->
        <div
            class="grid grid-cols-2 gap-3 p-3 rounded-md sm:grid-cols-3 opacity-90" style="background-color: #c19a6b;"
        >
            <div
                v-for="stamp in sortedStamps"
                :key="stamp.id"
                class="relative flex items-center space-x-3 border rounded-md border-gray-300 bg-white px-6 py-5 shadow-sm"
            >
                <!-- <div class="flex-shrink-0">
                    <img
                        class="h-10 w-10 rounded-full"
                        :src="person.imageUrl"
                        alt=""
                    />
                </div> -->
                <i
                    v-if="stamp.scan == 'yes'"
                    class="pi pi-check absolute left-[50%] transform translate-x-[-50%] text-green-400 text-4xl z-20"
                ></i>

                <div class="min-w-0 flex-1">
                    <span class="absolute inset-0" aria-hidden="true" />
                    <p class="text-3xl font-bold text-black">
                        {{ stamp.sort + 1 }}
                    </p>
                    <p class="truncate text-sm text-black">
                        {{ stamp.reward == "none" ? "None" : stamp.reward }}
                    </p>
                </div>
            </div>
            <!-- <div
                class="relative flex items-center space-x-3 border rounded-md border-gray-300 bg-blue-500 px-6 py-5 shadow-sm"
            ></div> -->
        </div>
    </FormContainer>
</template>
