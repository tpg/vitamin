import route from '../../vendor/tightenco/ziggy';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m.js';
import { Ziggy } from "./routes";

const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
if (baseUrl !== undefined) {
    Ziggy.url = baseUrl;
}

export {ZiggyVue, Ziggy};
