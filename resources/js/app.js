import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { InertiaProgress } from "@inertiajs/progress";

createInertiaApp({
    // Progress Indicator
    progress: {
        // The delay after which the progress bar will appear
        // during navigation, in milliseconds.
        delay: 250,

        // The color of the progress bar.
        color: "#29d",

        // Whether to include the default NProgress styles.
        includeCSS: true,

        // Whether the NProgress spinner will be shown.
        showSpinner: false,
    },
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            // Set Mixin
            .mixin({
                methods: {
                    // Method hasAnyPermission
                    hasAnyPermission: function (permissions) {
                        // Get Permissions from props
                        let allPermissions = this.$page.props.auth.permissions;

                        let hasPermission = false;
                        permissions.forEach(function (item) {
                            if (allPermissions[item]) hasPermission = true;
                        });

                        return hasPermission;
                    },

                    // Format Price
                    formatPrice(value) {
                        let val = (value / 1).toFixed(0).replace(".", ",");
                        return val
                            .toString()
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
                },
            })
            .use(plugin)
            .mount(el);
    },
});
