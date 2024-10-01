import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import PrimeVue from "primevue/config";
import InputText from "primevue/inputtext";
import Password from 'primevue/password';
import Button from "primevue/button";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
import ToastService from "primevue/toastservice";
import Message from "primevue/message";
import ConfirmationService from "primevue/confirmationservice";
import Tooltip from 'primevue/tooltip';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import Fieldset from 'primevue/fieldset';
import Panel from 'primevue/panel';
import Divider from 'primevue/divider';
import "primeicons/primeicons.css";
import "primevue/resources/themes/aura-light-indigo/theme.css";



const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue,
                {
                    zIndex:{
                        modal: 1100, 
                        overlay: 45
                    }
                })
            .use(ToastService)
            .use(ConfirmationService)

        app.component("Toast", Toast);
        app.component("ConfirmDialog", ConfirmDialog);
        app.component("InputText", InputText);
        app.component("Password", Password);
        app.component("Button", Button);
        app.component("Calendar", Calendar);
        app.component("Dropdown", Dropdown);
        app.component("Fieldset", Fieldset);
        app.component("Divider", Divider);
        app.component("Panel", Panel);
        app.component("Message", Message);
        app.directive('tooltip', Tooltip);

        return app.mount(el);
    },
    progress: {
        color: "#4aff84",
    },
});
