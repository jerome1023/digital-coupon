<script setup lang="ts">
import QrCode from "@/Components/QrCode.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Dialog from "primevue/dialog";
import { TPageProps } from "@/Types/type";
import { Head, usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const { my_coupons, flash } = usePage().props as TPageProps;

const alert = ref({
    isShow: false,
    severity: "",
    message: "",
});

const dialog = ref({
    isShow: false,
    reward: "",
});

onMounted(() => {
    if (flash?.reward) {
        dialog.value = {
            isShow: true,
            reward: flash.reward,
        };
    }

    if (flash?.message && flash?.status_code) {
        alert.value = {
            isShow: true,
            severity: "",
            message: flash.message,
        };

        if (flash.status_code !== 400) {
            alert.value.severity = "success";
        } else {
            alert.value.severity = "error";
        }
        setTimeout(() => {
            alert.value = {
                isShow: false,
                severity: "",
                message: "",
            };
            flash.message = null;
            flash.status_code = null;
        }, 3000);
    }
});

const closeDialog = () => {
    dialog.value = {
        isShow: false,
        reward: '',
    };
    flash.reward = null;
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8 space-y-6">
            <Dialog
                v-if="dialog.isShow"
                v-model:visible="dialog.isShow"
                modal
                class="w-screen sm:w-auto sm:min-w-[25rem] mx-5"
            >
                <template #container>
                    <div class="p-4 text-center relative">
                        <i
                            class="pi pi-check p-2 bg-green-500 rounded-full absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                        />
                        <p class="font-semibold text-md mt-2">
                            Congratulations!
                        </p>
                        <p class="text-md mb-5 mt-2">
                            {{ dialog.reward }}
                        </p>

                        <Button
                            @click="closeDialog"
                            label="Close"
                            severity="success"
                            size="small"
                            class="w-full bg-green-500 hover:bg-green-600"
                        />
                    </div>
                </template>
            </Dialog>

            <div class="flex justify-between items-center">
                <h2
                    class="ml-1 font-semibold text-lg md:text-xl text-gray-800 leading-tight"
                >
                    My Coupons
                </h2>

                <Head title="My Coupon" />
                <Button
                    @click="$inertia.visit(route('my_coupon.scan'))"
                    plain
                    text
                    size="small"
                    class="p-0"
                >
                    <svg
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="#000000"
                        class="h-6 w-6"
                    >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g
                            id="SVGRepo_tracerCarrier"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    d="M15 3h6v5h-2V5h-4V3zM9 3v2H5v3H3V3h6zm6 18v-2h4v-3h2v5h-6zm-6 0H3v-5h2v3h4v2zM3 11h18v2H3v-2z"
                                ></path>
                            </g>
                        </g>
                    </svg>
                </Button>
            </div>
            <Message v-if="alert.isShow" :severity="alert.severity">{{
                alert.message
            }}</Message>
            <ul
                role="list"
                class="grid grid-cols-1 gap-4 md:gap-6 sm:grid-cols-2 lg:grid-cols-3"
            >
                <!-- <li
                    v-if="my_coupons.data.length > 0"
                    v-for="my_coupon in my_coupons.data"
                    :key="my_coupon.id"
                    class="col-span-1 divide-y divide-gray-200 bg-blue-400 cursor-pointer"
                    @click="$inertia.visit(route('my_coupon.stamp',{id : my_coupon.id}))"
                >
                    <div class="flex w-full items-center p-5 relative">
                        <div
                            class="h-3 w-3 bg-gray-100 rounded-br-full absolute top-0 left-0"
                        />
                        <div
                            class="h-3 w-3 bg-gray-100 rounded-tr-full absolute bottom-0 left-0"
                        />
                        <div
                            class="h-3 w-5 bg-gray-100 rounded-b-full absolute top-0 right-[6rem]"
                        />
                        <div
                            class="h-3 w-5 bg-gray-100 rounded-t-full absolute bottom-0 right-[6rem]"
                        />
                        <div
                            class="h-3 w-3 bg-gray-100 rounded-bl-full absolute top-0 right-0"
                        />
                        <div
                            class="h-3 w-3 bg-gray-100 rounded-tl-full absolute bottom-0 right-0"
                        />
                        <div class="truncate flex-1">
                            <div
                                class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                            >
                                {{ my_coupon.coupon.store.name }}
                            </div>
                            <h3
                                class="truncate text-lg font-bold text-gray-900"
                            >
                                {{ my_coupon.coupon.name }}
                            </h3>
                            <p class=" truncate text-sm text-gray-500">
                                Valid Until {{ my_coupon.coupon.date_end }}
                            </p>
                        </div>
                        <Divider
                            layout="vertical"
                            class="h-[4.5rem]"
                            type="dashed"
                        />
                        <QrCode :value="my_coupon.coupon.id" size="70" />
                    </div>
                </li> -->
                <!-- <li
                    v-if="my_coupons.data.length > 0"
                    v-for="my_coupon in my_coupons.data"
                    :key="my_coupon.id"
                    class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow cursor-pointer"
                    @click="$inertia.visit(route('my_coupon.stamp',{id : my_coupon.id}))"
                >
                    <div
                        class="flex w-full items-center justify-between space-x-6 p-4"
                    >
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3
                                    class="truncate text-lg font-bold text-gray-900"
                                >
                                    {{ my_coupon.coupon.name }}
                                </h3>
                                <span
                                    class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                                >
                                    {{ my_coupon.coupon.store.name }}
                                </span>
                            </div>
                            <p class="truncate text-sm text-gray-500">
                                Valid Until {{ my_coupon.coupon.date_end }}
                            </p>
                        </div>
                        <Divider
                            layout="vertical"
                            class="h-[4.5rem]"
                            type="dashed"
                        />
                        <QrCode :value="my_coupon.coupon.id" size="70" />
                    </div>
                </li> -->

                <li
                    v-if="my_coupons.data.length > 0"
                    v-for="my_coupon in my_coupons.data"
                    :key="my_coupon.id"
                    class="relative col-span-1 divide-y divide-gray-200 rounded-lg shadow cursor-pointer opacity-90"
                    style="background-color: #c19a6b"
                    @click="
                        $inertia.visit(
                            route('my_coupon.stamp', { id: my_coupon.id })
                        )
                    "
                >
                    <div
                        v-if="my_coupon.status == true"
                        class="absolute inset-0 flex items-center justify-center z-30"
                    >
                        <div
                            class="text-red-500 text-6xl font-medium opacity-70 -rotate-[15deg] border-2 p-2 border-red-500 rounded-md"
                        >
                            Completed
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center space-x-3">
                            <h3
                                class="truncate text-lg font-bold text-gray-900"
                            >
                                {{ my_coupon.coupon.name }}
                            </h3>
                            <span
                                class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                            >
                                {{ my_coupon.coupon.store.name }}
                            </span>
                        </div>
                        <Divider />
                        <div
                            class="grid grid-cols-6 w-full items-center justify-center gap-1 mb-3"
                        >
                            <p
                                v-for="reward in my_coupon.coupon.coupon_rewards.sort(
                                    (a, b) => a.sort - b.sort
                                )"
                                class="m-auto relative w-9 h-9 flex justify-center items-center border rounded-full bg-white text-black"
                            >
                                {{ reward.sort + 1 }}
                                <i
                                    v-if="reward.scan == 'yes'"
                                    class="pi pi-check absolute left-[50%] transform translate-x-[-50%] text-green-400 text-xl z-20"
                                ></i>
                            </p>
                        </div>
                        <!-- <Divider class="my-2"/> -->
                        <div class="flex justify-between items-center">
                            <p class="truncate text-sm text-black">
                                Valid Until {{ my_coupon.coupon.date_end }}
                            </p>
                            <QrCode :value="my_coupon.coupon.id" size="50" />
                        </div>
                    </div>
                </li>
                <li v-else>No Coupon</li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
