<script setup>
import { ref, computed } from "vue";
const model = defineModel({
    type: String,
    required: true,
});

const isShow = ref(false);
const type = computed(() => (isShow.value ? "text" : "password"));
</script>

<template>
    <div class="mt-1 flex items-center relative">
        <input
            class="block w-full pr-9 border-gray-300  focus:ring-indigo-500 rounded-md shadow-sm"
            :type="type"
            v-model="model"
            ref="input"
        />
        <p
            @click="isShow = !isShow"
            :class="[
                isShow ? 'pi pi-eye' : 'pi pi-eye-slash',
                'absolute right-3 cursor-pointer text-gray-500',
            ]"
        ></p>
    </div>
</template>
