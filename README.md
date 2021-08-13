# Vitamin

A highly opinionated packaged boilerplate solution for Laravel.

## What
Vitamin will install all the bit and pieces needed to get Vite, Tailwind, Vue 3, Inertia and Ziggy working with Laravel running on a local Valet installation. This is super-duper opinionated, but could be customized to include other stuff.

## Private Package
Vitamin is currently a private package. I might release it as open source at some point, but not just yet. So, you'll need a Repman token to install Vitamin (which you have to ask me for). Once you have a token, you can add it to Composer using the following:

```shell
composer config --global --auth http-basic.thepublicgood.repo.repman.io token <TOKEN>
```

Then update your project `composer.json` file and add the following:

```json
{
    "repositories": [
        {
            "type": "composer", "url": "https://thepublicgood.repo.repman.io"
        }
    ]
}
```

Now install Vitamin using Composer:

```shell
composer require thepublicgood/vitamin
```

Once installed, run the Vitamin Artisan command:

```
php ./artisan vitamin:init
```

Vitamin will guide you through a few prompts and then install the entire boilerplate including required NPM and Composer packages. You can modify these as you need later, but you should let the process complete.

## Usage
Vitamin will create a few NPM scripts (although, note that it expectes Yarn to be present during installation). To start a new Vite dev server, run:

```shell
yarn dev
```

Vite will run a dev server on your local machine on port 3000 (it will automatically increment the port number of 3000 isn't available). You should see something like:

```
  vite v2.4.4 dev server running at:

  > Local:    http://vitamin.test:3000/
  > Network:  http://192.168.0.10:3000/

  ready in 571ms.
```

This is the dev server running. You'll need to make sure you create a new Valet link, but you should be able to visit your new project at `http://vitamin.test` or whatever your Valet address is.

### Building for production
To build your project for production:

```shell
yarn prod
```

As simple as that. Depending on the size of your project, building should be a fair amount quicker than Webpack. Once complete, there is a new `public/build` directory. You'll probably want to add that to your `.gitignore` file. It's not wize to include compiled assets in your repo.

### Valet
During development, all assets are served from the dev server running at port 3000. Vitamin includes a custom Valet driver (there is a `LocalValetDriver.php` file in your project root) that will ensure that assets served from `node_modules` are served correctly. I found that this was needed in a few edge cases. The custom driver extends the default `LaravelValetDriver` so you shouldn't have any problems running Valet.

### Inertia
Inertia is my default go to these days, so Vitamin will set up Inertia by default. During initialization, you're asked where your Vue components are stored. You can customize this location in `app.js` if you wish. Vite will load your Vue pages from there. The default Inertia documentation uses `resources/js/Pages`, but I like putting my views in `resources/views/Pages` these days, so Vitamin will make that suggestion. You can put them anywhere. The only requirement is that the location must be relative to the project root. So `./resources/views/Pages` or `./resources/js/Pages`.

### Ziggy
Ziggy is a JavaScript route helper for Laravel. If allows you to use your Laravel defined routes from within your JavaScript front-end. It ships with a fairly decent Vue plugin, so it's included by default. Inside your Vue components, you'll have access to `route` function which you can pass any Laravel defined route name. Something like:

```javascript
this.route('home');
```

Vitamin sets up Ziggy routes in the `resources/js/routes.js` file. This file needs to be regenerated each time your change your Laravel routes. Vitamin does this automatically by creating a simple Vite plugin that will run the `yarn routes` script each time a Laravel routes file changes. However, if you ever need to rebuild the routes, simply run `yarn routes` yourself.

## Using this with Attaché
Attache is an opinionated deployment solution for Laravel. However, it was designed around how I used Webpack. Vite has changed a few things and now breaks how Attaché works. However, you can fool Attaché into working by simply creating an empty `public/js` and an empty `public/css` directories and making sure to include `public/build` in the `assets` setting. That way Attaché will copy the empty `js` and `css` directories, as well as the compiled assets in `build`. Alternatively you can use Envoy easily enough.
