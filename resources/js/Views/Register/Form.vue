<script setup lang="ts">
import FormGroup from "@/Components/FormGroup.vue";

defineProps<{
    form: any;
}>();
</script>

<template>
    <FormGroup type="text" name="first_name" label="Firstname" :form="form" />
    <FormGroup type="text" name="last_name" label="Lastname" :form="form" />
    <FormGroup type="text" name="username" label="Username" :form="form" />
    <FormGroup type="password" name="password" label="Password" :form="form" />
    <FormGroup
        type="password"
        name="password_confirmation"
        label="Confirm Password"
        :form="form"
    />
</template>
