<script setup lang="ts">
import FormContainer from "@/Components/FormContainer.vue";
import FormGroup from "@/Components/FormGroup.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";
import draggable from "vuedraggable";
import { TOptions, TPageDetails } from "@/Types/type";

const props = defineProps<{
    form: any;
    page: TPageDetails;
    options?: [];
}>();

const StoreOptions: TOptions = props.options.map((store: any) => ({
    code: store.id,
    name: store.name,
}));

const increment = () => {
    const sort =
        props.form.coupon_rewards.length > 0
            ? props.form.coupon_rewards[props.form.coupon_rewards.length - 1]
                  .sort + 1
            : 0;
    props.form.coupon_rewards.push({
        reward: "",
        details: "",
        sort: sort,
    });
};

const removeItem = (index: number) => {
    props.form.coupon_rewards.splice(index, 1);
    props.form.coupon_rewards.forEach((reward: any, index: number) => {
        reward.sort = index;
    });
};

const updateSort = (event: any) => {
    let errors = {};
    props.form.coupon_rewards.forEach((reward: any, index: number) => {
        const value = props.form.errors[`coupon_rewards.${reward.sort}.reward`];
        if (value) {
            errors[`coupon_rewards.${index}.reward`] = value;
        }
        reward.sort = index;
    });
    Object.keys(props.form.errors).forEach((key) => {
        if (key.startsWith("coupon_rewards")) {
            delete props.form.errors[key];
        }
    });

    Object.assign(props.form.errors, errors);
};
</script>

<template>
    <FormContainer :form="form" :page="page">
        <FormGroup
            name="store_id"
            type="select"
            :form="form"
            label="Store"
            :options="StoreOptions"
        />
        <FormGroup name="name" type="text" :form="form" label="Coupon Name" />
        <FormGroup
            name="date_start"
            type="date"
            :form="form"
            label="Date Start"
        />
        <FormGroup name="date_end" type="date" :form="form" label="Date End" />
        <Divider align="center" class="col-span-full">
            <h3 class="font-semibold text-sm">Reward Details</h3>
        </Divider>
        <draggable
            :list="form.coupon_rewards"
            class="col-span-full"
            @end="updateSort"
        >
            <template #item="{ element, index }">
                <div class="">
                    <!-- <i
                        @click="removeItem(index)"
                        class="pi pi-trash ml-auto text-red-500 hover:bg-red-100"
                    /> -->
                    <div class="flex items-center">
                        <p class="font-medium">{{ index + 1 }}</p>
                        <Button
                            @click="removeItem(index)"
                            icon="pi pi-trash"
                            class="ml-auto"
                            severity="danger"
                            size="small"
                            text
                        ></Button>
                    </div>
                    <div class="w-full md:grid grid-cols-2 gap-x-4">
                        <div class="mb-4 md:mb-0">
                            <InputLabel
                                for="reward"
                                value="Reward Title"
                                class="mb-2"
                            />
                            <TextInput name="reward" v-model="element.reward" />
                            <InputError
                                class="mt-2"
                                :message="
                                    form.errors[
                                        `coupon_rewards.${index}.reward`
                                    ]
                                "
                            />
                        </div>
                        <div>
                            <InputLabel
                                for="details"
                                value="Details"
                                class="mb-2"
                            />
                            <TextInput
                                name="details"
                                v-model="element.details"
                            />
                        </div>
                        <Divider type="dashed" class="col-span-full" />
                    </div>
                </div>
            </template>
        </draggable>
        <div class="col-span-full">
            <Button
                @click="increment"
                label="Add Reward"
                severity="primary"
                size="small"
            />
        </div>
        <InputError class="mt-2" :message="form.errors.coupon_rewards" />
    </FormContainer>
</template>
