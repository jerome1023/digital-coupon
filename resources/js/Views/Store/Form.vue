<script setup lang="ts">
import FormContainer from "@/Components/FormContainer.vue";
import FormGroup from "@/Components/FormGroup.vue";
import { TOptions, TPageDetails } from "@/Types/type";

const props = defineProps<{
    form: any;
    page: TPageDetails;
    options?: [];
}>();

const OwnerOptions: TOptions = props.options.map((owner: any) => ({
    code: owner.id,
    name: `${owner.first_name} ${owner.last_name}`,
}));
</script>

<template>
    <FormContainer :form="form" :page="page">
        <FormGroup
            name="owner_id"
            type="select"
            :form="form"
            label="Owner"
            :options="OwnerOptions"
        />
        <FormGroup name="name" type="text" :form="form" label="Store Name" />
        <FormGroup name="address" type="text" :form="form" label="Address" />
    </FormContainer>
</template>
