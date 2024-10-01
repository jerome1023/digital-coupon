<script setup lang="ts">
import FormContainer from "@/Components/FormContainer.vue";
import { router } from "@inertiajs/vue3";
import { QrcodeStream, QrcodeCapture } from "qrcode-reader-vue3";
import { useToast } from "primevue/usetoast";
import { TPageDetails } from "@/Types/type";

const toast = useToast();

const page = <TPageDetails>{
    pageTitle: "Scan Coupon",
    path: "my_coupon.index",
};

function onDecode(decodedData: any) {
    router.post(route('my_coupon.store'), decodedData, {
        // onSuccess: () => {
        //     toast.add({
        //         severity: "success",
        //         summary: "Success",
        //         detail: "Coupon scan successfully",
        //         life: 3000,
        //     });
        // },
    });
}
</script>

<template>
    <FormContainer :page="page">
        <!-- <Panel
            header="Use Camera"
            toggleable
        > -->
        <div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            <div class="-px-3 relative h-[500px] max-w-[500px] m-auto">
                <qrcode-stream
                    @decode="onDecode"
                    
                ></qrcode-stream>
                <div
                    class="border-2 border-green-600 h-[150px] w-[150px] md:h-[200px] md:w-[200px] absolute m-auto top-0 right-0 bottom-0 left-0"
                ></div>
            </div>
        <!-- </Panel> -->
        <Divider align="center">Or</Divider>
        <Panel header="Upload Image" toggleable :collapsed="true">
            <div class="truncate">
                <qrcode-capture @decode="onDecode"></qrcode-capture>
            </div>
        </Panel>
    </FormContainer>
</template>
