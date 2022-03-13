import ziggyRoute from '@/../../vendor/tightenco/ziggy';
import { Ziggy } from "./Ziggy.js";

const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
if (!!baseUrl) {
    Ziggy.url = baseUrl;
}

export function route (name, params, absolute) {
    return ziggyRoute(name, params, absolute, Ziggy);
}
