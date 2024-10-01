<template>
    <div class="mb-4">
        <InputLabel :for="name" :value="label" />

        <div class="mt-2">
            <TextInput
                v-if="type == 'text'"
                v-model="form[name]"
                :form="form[name]"

            />
            <Password v-if="type == 'password'" v-model="form[name]" />
            <Select
                v-if="type == 'select'"
                v-model="form[name]"
                :options="options"
                :form="form[name]"
            />
            <Datepicker
                v-if="type == 'date'"
                v-model="form[name]"
                :val="form[name]"
            />
        </div>

        <InputError class="mt-2" :message="form.errors[name]" />
    </div>
</template>

<script setup lang="ts">
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Password from "@/Components/Form/Password.vue";
import Select from "@/Components/Form/Select.vue";
import Datepicker from "@/Components/Form/Datepicker.vue";
import { TOptions } from "@/Types/type";

defineProps<{
    name: string;
    label: string;
    type: string;
    form: any;
    options?: TOptions;
    isDisabled?: boolean;
}>();
</script>
