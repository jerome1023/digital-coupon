<template>
    <!-- <select
        v-model="selected"
        class="block w-full text-black border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    >
        <option disabled>Select {{ label }}</option>
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
        >
            {{ option.name }}
        </option>
    </select> -->
    <!-- {{ options }} -->

    <Dropdown v-model="selected" :options="options" :filter="filter" optionLabel="name" optionValue="code" checkmark :highlightOnSelect="true" class="w-full md:w-14rem" />
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { TOptions } from "@/Types/type";

const props = defineProps<{
    options?: TOptions;
    form: string;
}>();



const selected = ref(props.form);
const filter = computed(()=>{
    return props.options.length > 10 ? true : false
})

</script>
