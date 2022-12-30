[![Tests](https://github.com/tpg/vitamin/actions/workflows/php.yml/badge.svg)](https://github.com/tpg/vitamin/actions/workflows/php.yml)

# Vitamin

> Laravel now has Vite support out of the box. Vitamin will no longer receive any new updates. You get the same
> functionality with Laravel + Breeze.

A highly opinionated packaged boilerplate solution for installing Vite, Tailwind and Inertia (along a few other things) into a Laravel app.

## What

Vitamin will install all the bits and pieces needed to get Vite, Tailwind, Vue 3, Inertia and Ziggy working with Laravel while running on a local Valet installation. This is super-duper opinionated, but could be customized to include other stuff.

### But Laravel now uses Vite instead of Laravel Mix?
As of Laravel 9.2, Vite to bundle assets instead of Laravel Mix. However, I'm planning to maintain Vitamin for a little while longer. At least for now. So if you're using Vitamin, there's no need to worry and it still works in exactly the same way.

## Installation

Like everything Laravel, install Vitamin via Composer:

```shell  
composer require thepublicgood/vitamin  
```  

Once installed, run the Vitamin Artisan command:

```shell  
php ./artisan vitamin:init  
```  

Vitamin will guide you through a few prompts and then install the entire boilerplate including required NPM and Composer packages. You can modify these as you need later, but you should let the process complete.

Link a Valet host if you haven't already:

```shell  
valet link mysite  
```  

Run the Vite dev server:

```shell  
php ./artisan vitamin:serve  
```  

Open your browser:

```  
http://mysite.test  
```  

If you see a "Welcome" message, you're good to go.

### What gets installed:

The following Composer packages are installed:

- [inertiajs/inertia-laravel](https://github.com/inertiajs/inertia-laravel)
- [tightenco/ziggy](https://github.com/tighten/ziggy)

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

Vitamin will add a few NPM scripts. Previous versions required that the "Yarn" dependency manager was installed. Later versions will ask if you prefer "npm" or "yarn".

Once all installation is complete, you can start a new Vite dev server, using the `vitamin:serve` Artisan command. A `dev` NPM script has also been added so you can start the dev server using your node dependency manager as well:

```shell  
yarn dev  
  
// or  
  
npm run dev  
  
// or  
  
php ./artisan vitamin:serve  
```  

Vite will run a dev server on your local machine on port 3000. Once it's running, you should see something like:

```  
  vite v2.4.4 dev server running at:  
  
  > Local:    http://vitamin.test:3000/  
  > Network:  http://192.168.0.10:3000/  
  
  ready in 571ms.  
```  

You'll need to create a new Valet link and then you should be able to visit your new project at `http://vitamin.test` or whatever your dev address is.

### Port number

By default Vite will run on port 3000. You can specifty the port number if you need to by changing the `port` setting in the `vitamin.php` config file.

```php  
return [  
    "port" => 3002,  
    //...  
]  
```  

Or by passing the port number to the `vitamin:serve` command:

```shell  
php ./artisan vitamin:serve --port=3010  
```  

### Building for production

To build your project for production:

```shell  
yarn prod  
  
// or  
  
npm run prod  
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

During development, all assets are served from the dev server running at port 3000. Vitamin includes a custom Valet driver (there should be a `LocalValetDriver.php` file in your project root) that will ensure that assets served from `node_modules` are served correctly. I found that this was needed in a few edge cases. The custom driver extends the default `LaravelValetDriver` so you shouldn't be running into any issues. However, if you find that you have issues using the custom driver, simply delete the file and Valet will go on using it's default driver.

### Inertia

Inertia is my go to these days, so Vitamin will set it up by default. During initialisation, you're asked where your Vue components are stored. You can customize this location in `app.js` if you wish. Vite will load your Vue pages from there. The Inertia documentation uses `resources/js/Pages`, so Vitamin will make that suggestion. However, technically, you can put them anywhere. The only requirement Vitamin imposes is that the location must be child of the JS path.

### Ziggy

Ziggy is a JavaScript route helper for Laravel. If allows you to use your Laravel defined routes from within your JavaScript front-end. Vitamin comes with a `Router` script that provides a `route` function. You can import this into any Vue file to get access to your Laravel routes:

```javascript  
import {route} from '@/Scripts/Routing/Router.js'  
  
route('home');  
```  

Vitamin sets up Ziggy routes in the `resources/js/Scripts/Routing/Ziggy.js` file. This file needs to be regenerated each time your change your Laravel routes. Vitamin does this automatically by creating a simple Vite plugin that will run the `yarn routes` script each time a Laravel routes file changes. However, if you ever need to rebuild the routes, simply run `yarn routes` yourself. If you. change the name of this file or want to place it somewhere else, remember to update the reference in the `Router.js` file as well.

> In previous versions of Vitamin, the Ziggy Vue plugin was used, but I've found the newer approach to be more flexible and is better when using the Vue composition API.

## TLS Certificates

It's possible to get all of this to work with TLS as well so you can use an `https` address during development. First, you need to get Valet to secure your site which already provides a simple solution for this. If you're serving your site at `mysite.test` then you can get Valet to generate a new certificate:

```shell  
valet secure mysite  
```  

It will likely ask you for your password.

You'll also need to get Vite to do the same thing. The easiest way to do this is to use the `mkcert` Vite plugin:

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

Lastly, update the `vitamin.php` config file and set the `https` option to true:

```json  
{  
     "https": true  
}  
```  

The first time you run `yarn dev`, you'll likely be asked for your password so that the mkcert plugin can generate a new certificate.
