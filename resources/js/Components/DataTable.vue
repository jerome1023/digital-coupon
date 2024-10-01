<template>
    <AuthenticatedLayout>
        <div class="px-4 pb-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <DataTable
                v-model:filters="filters"
                removableSort
                :value="table.contents"
                :paginator="
                    table.contents.length < 10 || user.data.role.name == 'admin'
                        ? true
                        : false
                "
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :paginatorTemplate="{
                    '640px':
                        'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                    default:
                        'RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                }"
                :currentPageReportTemplate="currentPageReportTemplate"
                dataKey="id"
            >
                <template
                    v-if="
                        table.contents.length < 10 ||
                        user.data.role.name == 'admin'
                    "
                    #header
                >
                    <nav v-if="$slots.nav" class="pb-5">
                        <slot name="nav" />
                    </nav>
                    <div class="flex justify-between items-center">
                        <Button
                            class="hidden md:block"
                            type="button"
                            icon="pi pi-eraser"
                            label="Clear"
                            size="small"
                            outlined
                            @click="clearFilter()"
                        />
                        <span class="relative w-full md:w-auto">
                            <i
                                class="pi pi-search absolute top-2/4 -mt-2 left-3 text-surface-400 dark:text-surface-600"
                            />
                            <InputText
                                v-model="filters['global'].value"
                                placeholder="Keyword Search"
                                class="pl-10 font-normal w-full rounded-md"
                                size="small"
                            />
                        </span>
                    </div>
                </template>
                <template #empty> No record found. </template>
                <Column
                    v-for="col of table.columns"
                    :key="col.field"
                    :field="col.field"
                    :header="col.header"
                    sortable
                    style="min-width: 14rem"
                >
                </Column>
                <Column v-if="table.actions.length > 0">
                    <template #body="{ data }">
                        <div class="flex justify-center gap-2">
                            <template
                                v-for="action in table.actions"
                                :key="action.label"
                            >
                                <Button
                                    class="h-8 w-8"
                                    :severity="action.severity"
                                    :icon="action.icon"
                                    outlined
                                    size="small"
                                    :aria-label="action.label"
                                    v-tooltip.top="action.label"
                                    @click="
                                        toggleAction(
                                            action.label.toLowerCase(),
                                            data.id
                                            // action?.event()
                                        )
                                    "
                                />
                            </template>
                        </div>
                    </template>
                </Column>
            </DataTable>
            <Dialog v-model:visible="isShow" modal class="overflow-hidden bg-green-500 border-0">
                <!-- :breakpoints="{ '576px': '80vw', '768px': '', '992px': '', '1200px': '15vw' }" -->
                <template #container>
                    <div class="flex flex-col text-center p-3">
                        <i v-tooltip.top="'Close'" @click="isShow = false" class="pi pi-times-circle cursor-pointer absolute right-3 top-3 text-white text-md" />
                        <p class="text-2xl font-meduim text-white my-3">Scan Me</p>
                        <div class="relative p-3 bg-white rounded-md">
                            <QrCode v-if="isShow" :value="qr" size="170" />
                        </div>
                    </div>
                </template>
            </Dialog>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed } from "vue";
import { FilterMatchMode } from "primevue/api";
import { router } from "@inertiajs/vue3";
import { useWindowSize } from "@vueuse/core";
import { TTable } from "@/Types/type";
import { usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import useConfirmDialog from "@/Composables/useDialog";
import Dialog from "primevue/dialog";
import QrCode from "@/Components/QrCode.vue";

const windowSize = useWindowSize();
const { confirmDelete } = useConfirmDialog();
const { user } = usePage().props.auth;
const filters = ref();
const isShow = ref(false);
const qr = ref();

const props = defineProps<{
    table: TTable;
}>();

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};

initFilters();

const clearFilter = () => {
    initFilters();
};

const paginator = ref(false);

const currentPageReportTemplate = computed(() => {
    return windowSize.width.value < 640
        ? "{currentPage}"
        : "Showing {first} to {last} of {totalRecords}";
});

const toggleAction = (label: string, id: string) => {
    if (label == "edit") {
        router.visit(`${router.page.url}/${id}/${label}`);
    } else if (label == "scan qr") {
        isShow.value = true;
        qr.value = id;
    } else {
        confirmDelete(router.page.url, id, props.table.contents);
    }
};
</script>
