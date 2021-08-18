import vue from '@vitejs/plugin-vue';
import path from 'path';
import {exec} from 'child_process';

export default ({command}) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: 'fake_dir_that_doesnt_exist',
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        },
    },
    resolve: {
        alias: {
            '@Pages': path.resolve(__dirname + '/resources/$PAGESPATH$'),
            '@Components': path.resolve(__dirname + '/resources/$COMPONENTSPATH$')
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

