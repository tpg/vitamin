import vue from '@vitejs/plugin-vue';
import path from 'path';
import {exec} from 'child_process';

export default ({command}) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: false,
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/$JSPATH$/app.js',
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname + '/resources/$JSPATH$'),
        }
    },
    plugins: [
        vue(),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        },
        {
            name: 'rebuildRoutes',
            handleHotUpdate({file, server}) {
                if (file.includes('routes') && file.endsWith('.php')) {
                    exec('yarn routes');
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    })
                }
            }
        },
    ],
});

