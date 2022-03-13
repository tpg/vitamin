<script setup>
import {route} from '@/Scripts/Routing/Router.js';

//...
</script>

<template>
    <div class="container mx-auto text-center py-10">
        <h1 class="font-bold text-4xl mb-2">Welcome</h1>
        <p>Laravel, Tailwind, Vue, Vite and Ziggy</p>
        <hr class="my-5" />
        <div class="w-1/2 mx-auto text-center prose max-w-none">
            <p>
                To run your site in dev mode use:
            </p>
            <pre>yarn dev</pre>
            <hr class="my-5" />
            <p>
                When you're ready to build for production:
            </p>
            <pre>yarn prod</pre>
            <hr class="my-5" />
            <p>
                Routes are rebuilt automatically when they change, but if you need to do it yourself:
            </p>
            <pre>yarn routes</pre>
            <hr class="my-5" />
            <p>
                This view is located at:
            </p>
            <pre>resources/$JSPATH$/Pages/Welcome.vue</pre>
        </div>
    </div>
</template>

<style scoped>

</style>
