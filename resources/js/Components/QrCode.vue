<script setup>
import { ref } from "vue";
import QrcodeVue from "qrcode.vue";

const props = defineProps({
    value: String,
    size: String
})

const { Level, RenderAs } = QrcodeVue;
const level = ref < Level > "H";
const renderAs = ref < RenderAs > "canvas";
</script>

<template>
    <qrcode-vue :value="value" :level="level" :size=size :render-as="renderAs" />
</template>
