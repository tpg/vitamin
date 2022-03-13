[![Tests](https://github.com/tpg/vitamin/actions/workflows/php.yml/badge.svg)](https://github.com/tpg/vitamin/actions/workflows/php.yml)

# Vitamin

A highly opinionated packaged boilerplate solution for installing Vite, Tailwind and Inertia (along a few other things) into a Laravel app.

## What
Vitamin will install all the bits and pieces needed (plus a few others, because I use them regularly) to get Vite, Tailwind, Vue 3, Inertia and Ziggy working with Laravel while running on a local Valet installation. This is super-duper opinionated, but could be customized to include other stuff.

I've also included some packages that I use often, but they can be removed if you don't need them.

## Installation
Like everything Laravel, install Vitamin via Composer:

```shell
composer require thepublicgood/vitamin
```

Once installed, run the Vitamin Artisan command:

```
php ./artisan vitamin:init
```
Vitamin will guide you through a few prompts and then install the entire boilerplate including required NPM and Composer packages. You can modify these as you need later, but you should let the process complete.

Link a Valet host if you haven't already:

```
valet link mysite
```

Open your browser:

```
http://mysite.test
```

If you see a "Welcome" message, you're good to go.

### What gets installed:

The following Composer packages are installed:

- [inertiajs/inertia-laravel](https://github.com/inertiajs/inertia-laravel)
- [laravel/horizon](https://github.com/laravel/horizon)
- [laravel/telescope](https://github.com/laravel/telescope)
- [thepublicgood/is-presentable](https://github.com/tpg/is-presentable)
- [tightenco/ziggy](https://github.com/tighten/ziggy)
- [laravel/envoy](https://github.com/laravel/envoy) (dev)
- [roave/security-advisories](https://github.com/Roave/SecurityAdvisories) (dev)

The following NPM packages are installed:

- [@heroicons/vue](https://github.com/tailwindlabs/heroicons)
- [@inertiajs/inertia](https://github.com/inertiajs/inertia)
- [@inertiajs/inertia-vue3](https://github.com/inertiajs/inertia)
- [@inertiajs/progress](https://github.com/inertiajs/progress)
- [@tailwindcss/typography](https://github.com/tailwindlabs/tailwindcss-typography)
- [@vitejs/plugin-vue](https://github.com/vitejs/vite/tree/main/packages/plugin-vue)
- [@vue/compiler-sfc](https://github.com/vuejs/core/tree/main/packages/compiler-sfc)
- [autoprefixer](https://github.com/postcss/autoprefixer)
- [axios](https://github.com/axios/axios)
- [lodash](https://github.com/lodash/lodash)
- [postcss](https://github.com/postcss/postcss)
- [tailwindcss](https://github.com/tailwindlabs/tailwindcss)
- [vite](https://github.com/vitejs/vite)
- [vue](https://github.com/vuejs/vue)

## Usage
Vitamin will add a few NPM scripts (note that it expects Yarn to be present during installation). To start a new Vite dev server, run:

```shell
yarn dev

// or

php ./artisan vitamin:serve
```

Vite will run a dev server on your local machine on port 3000 (it will automatically increment the port number if 3000 isn't available). Once it's running, you should see something like:

```
  vite v2.4.4 dev server running at:

  > Local:    http://vitamin.test:3000/
  > Network:  http://192.168.0.10:3000/

  ready in 571ms.
```

This is the dev server. You'll also need to make sure you create a new Valet link, then you should be able to visit your new project at `http://vitamin.test` or whatever your Valet address is.

### Port number
By default Vite will run on port 3000 but will increment the port number by 1 if 3000 is already in use. Vitamin won't know that the port number has been incremented, but you can specify a port number by changing the `port` setting in the `vitamin.php` config file.

```php
return [
	"port" => 3002,
	//...
]
```

### Building for production
To build your project for production:

```shell
yarn prod
```

As simple as that. Depending on the size of your project, building should be a fair amount quicker than Webpack. Once complete, there is a new `public/build` directory. You'll probably want to add that to your `.gitignore` file. It's not wize to include compiled assets in your repo.

### The View Composer
The heart of Vitamin is a simple Laravel view composer that ensures the correct resources are inserted into the page. The view composer is included with the package, but you can extend it if you want to make changes. For example, if you're using TypeScript, you'll probably want to change the `app.js` file for an `app.ts` file and you'll need to update the view composer to point to the correct filename. To do this, create a new `AppComposer` class in your project and extend the `TPG\Vitamin\Composers\AppComposer` class. You can then override the `$jsPath` property:

```php
namespace App\Composers;

use TPG\Vitamin\Composers\AppComposer as VitaminAppComposer;

class AppComposer extends VitaminAppComposer
{
    protected string $jsPath = 'resources/js/app.ts';
}
```

You'll need to make sure your app binds your new composer instead of the default one. You can do this through the `vitamin.php` config file which you'll find in your `config` directory. Simply change the `composer` config option to point to your new class:

```php
[
    'composer' => App\Composers\AppComposer::class,
]
```

That's it. Now your app will use your new view composer instead of the default Vitamin one. If you need to override the `compose` method in your view composer, remember to call `parent::compose()`:

```php
public function compose(View $view): void
{
    // Anything custom you need to do goes here...
    
    parent::compose($view);
}
```

If you're not familiar with Laravel view composers, take a look at the documentation [here](https://laravel.com/docs/views#view-composers).

### Valet
During development, all assets are served from the dev server running at port 3000. Vitamin includes a custom Valet driver (there should be a `LocalValetDriver.php` file in your project root) that will ensure that assets served from `node_modules` are served correctly. I found that this was needed in a few edge cases, which is why I included it. The custom driver extends the default `LaravelValetDriver` so you shouldn't have any problems running Valet.

### Inertia
Inertia is my go to these days, so Vitamin will set it up by default. During initialisation, you're asked where your Vue components are stored. You can customize this location in `app.js` if you wish. Vite will load your Vue pages from there. The Inertia documentation uses `resources/js/Pages`, so Vitamin will make that suggestion. However, technically, you can put them anywhere. The only requirement is that the location must be child of the JS path.

### Ziggy
Ziggy is a JavaScript route helper for Laravel. If allows you to use your Laravel defined routes from within your JavaScript front-end. Vitamin comes with a `Router` script that provides a `route` function. You can import this into any Vue file to get access to your Laravel routes:

```javascript
import {route} from '@/Scripts/Routing/Router.js'

route('home');
```

Vitamin sets up Ziggy routes in the `resources/js/Scripts/Routing/Ziggy.js` file. This file needs to be regenerated each time your change your Laravel routes. Vitamin does this automatically by creating a simple Vite plugin that will run the `yarn routes` script each time a Laravel routes file changes. However, if you ever need to rebuild the routes, simply run `yarn routes` yourself. If you. change the name of this file or want to place it somewhere else, remember to update the reference in the `Router.js` file as well.

In previous versions of Vitamin, the Ziggy Vue plugin was used, but since I don't use that anymore and now have

## TLS Certificates
It's possible to get all of this to work with TLS as well so you can use an  `https` address during development. First, you need to get Valet to secure your site. Valet provides a simple solution for this. If you're serving your site at `mysite.test` then you can get Valet to generate a new certificate:

```shell
valet secure mysite
```

It will likely ask you for your password. You'll also need to get Vite to do the same thing. The easiest way to do so is to use the `mkcert` Vite plugin:

```shell
yarn add vite-plugin-mkcert -D
```

Update the `vite.config.js` file and set `server.https` to `true` and add `mkcert()` to the plugins array:

```js
export default({command}) => ({
    //...

    server: {
        https: true,
    },

    plugins: [
        vue(),
        mkcert(),

        //..
    ],
});
```

Lastly update the `package.json` file to tell Vite to run in `https` mode:

```json
{
    "scripts": {
        "dev": "vite serve --host=mysite.test --https"
    }
}
```

The first time you run `yarn dev`, you'll likely be asked for your password so that the mkcert plugin can generate a new certificate. I might add an HTTPS question to the Vitamin setup at some point. If and when I do, I'll update this.
