import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from "@inertiajs/progress";

InertiaProgress.init();

createInertiaApp({
    resolve: async (name: string) => {
        const pages = import.meta.glob('../$PAGESPATH$/**/*.vue')

        return (await pages[`../$PAGESPATH$/${name}.vue`]()).default;
    },
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el);
    },
});
