import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from "@inertiajs/progress";
import {ZiggyVue, Ziggy} from './router';

InertiaProgress.init();

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('../../$VUEPATH$/Pages/**/*.vue')

        return (await pages[`../../$VUEPATH$/Pages/${name}.vue`]()).default;
    },
    setup({ el, app, props, plugin }) {
        const vue = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy);

        vue.mount(el);
    },
});
