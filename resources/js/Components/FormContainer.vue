<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { TPageDetails } from "@/Types/type";

defineProps<{
    form?: any;
    page: TPageDetails;
}>();
</script>

<template>
    <Head :title="page.pageTitle" />
    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ page.pageTitle }}
            </h2>
        </template> -->
        <div class="flex justify-center">
            <div
                v-if="page.formTitle"
                class="w-full p-4 sm:p-8 bg-white shadow sm:rounded-lg"
            >
                <Fieldset :legend="page.formTitle">
                    <div class="mt-5 md:grid md:grid-cols-2 gap-x-4">
                        <slot></slot>
                    </div>
                </Fieldset>

                <div class="mt-6 flex items-center justify-end gap-x-3">
                    <Button
                        @click="$inertia.visit(route(page.path))"
                        type="button"
                        label="Back"
                        size="small"
                        text
                        severity="secondary"
                    />
                    <Button
                        type="submit"
                        label="Save"
                        size="small"
                        severity="success"
                        :disabled="form.processing"
                        :loading="form.processing"
                    />
                </div>
            </div>
            <div v-else class="w-full p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <slot />
                <div class="mt-6 flex items-center justify-end gap-x-3">
                    <Button
                        @click="$inertia.visit(route(page.path))"
                        type="button"
                        label="Back"
                        size="small"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
