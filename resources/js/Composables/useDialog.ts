import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { useForm } from "@inertiajs/vue3";

export default function useConfirmDialog() {
    const confirm = useConfirm();
    const toast = useToast();
    const form = useForm({});

    const confirmDelete = (
        currentPage: string,
        id: string,
        tableContents: any
    ) => {
        const url = currentPage.split("/")[1];
        confirm.require({
            message: "Do you want to delete this record?",
            header: "Confirmation",
            icon: "pi pi-info-circle",
            position: "top",
            rejectLabel: "Cancel",
            acceptLabel: "Delete",
            rejectClass: "p-button-secondary p-button-outlined",
            acceptClass: "p-button-danger",
            accept: () => {
                
                form.delete(route(`${url}.destroy`, id), {
                    preserveScroll: true,
                });
                
                const index = tableContents.findIndex(
                    (item: {id:string}) => item.id === id
                );
                if (index !== -1) {
                    tableContents.splice(index, 1);
                }
                toast.add({
                    severity: "info",
                    summary: "Confirmed",
                    detail: "Record deleted successfully",
                    life: 3000,
                });
            },
            reject: () => {
                toast.add({
                    severity: "error",
                    summary: "Rejected",
                    detail: "You have rejected",
                    life: 3000,
                });
            },
        });
    };

    return {
        confirmDelete,
    };
}
