<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import {
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture,
} from "qrcode-reader-vue3";
import { router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import { ref } from "vue";
const toast = useToast();
const fileInputRef = ref(null);
const data = ref(null)
function onDecode(decodedData) {
    data.value = decodedData
    // router.post("my_coupon/store", decodedData, {
    //     onSuccess: () => {
    //         toast.add({
    //             severity: "success",
    //             summary: "Success",
    //             detail: "Coupon scan successfully",
    //             life: 3000,
    //         });
    //         if(fileInputRef.value){
    //             fileInputRef.value.$el = null;
    //         }
    //     },
    // });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- <div>
                        <div class="mb">Qr Stream</div>
                        <div class="flex justify-center">
                            <qrcode-stream
                                @decode="onDecode"
                                class="mb border border-red-600"
                            >
                                <div class=""></div>
                            </qrcode-stream>
                        </div>
                        <div class="result">Result: {{ data }}</div>
                    </div>
                    <qrcode-capture
                    :ref="fileInputRef"
                        @decode="onDecode"
                        class="mt-4 p-2 border border-gray-300 rounded-md"
                    ></qrcode-capture>
                    <div class="result">Result: {{ data }}</div> -->
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
