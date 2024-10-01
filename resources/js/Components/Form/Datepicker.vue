<template>
    <Calendar
        class="w-full"
        v-model="date"
        dateFormat="yy-mm-dd"
        showIcon
        iconDisplay="input"
        inputId="icondisplay"
    />
</template>

<script setup lang="ts">
import { ref } from "vue";

const props = defineProps<{
    form: string;
}>();

const date = ref(props.form || null);
</script>
