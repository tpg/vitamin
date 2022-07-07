import ziggyRoute from '@/../../vendor/tightenco/ziggy';
import { Ziggy } from "./Ziggy.js";

const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
if (!!baseUrl) {
    Ziggy.url = baseUrl;
}

export function route (name: string, params?: string[]|undefined, absolute?: boolean|undefined) {
    return ziggyRoute(name, params, absolute, Ziggy);
}
