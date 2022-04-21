# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] 2022-04-21
### Fixed
- Fixed a small bug when installing composer dependencies that outputed text even when the verbosity was low.
- Made an update to the README file to state that the dev server needs to be started before browsing to the site after a fresh install.

## [0.6.2] 2022-03-29
### Fixed
- The vitamin:serve Artisan command was including the --https flag even if the https config option was set to false.

## [0.6.1] 2022-03-14
### Added
- Added https options to the vitamin.php config file
- Added an --https flag to the vitamin:serve Artisan command.

## [0.6.0] 2022-03-13
### Added
- Replaced router.js with Scripts/Routing/Router.js.
- The @tailwindcss/typography dependency has been added.

### Changed
- Updated Welcome.vue.
- Cleaned up the InitCommand and moved a few things around.
- No longer using the Ziggy Vue plugin. Import {route} from the Router.js file instead.

### Removed
- Removed the thepublicgood/deadbolt dependency, as it has a fairly specific use case.

## [0.5.1] 2022-02-25
### Fixed
- Fixes an issue where the package.json file is overwritten AFTER node dependencies are installed.

## [0.5.0] 2022-02-19
### Added
- Will now update the APP_URL setting in your .env file.
- Places a new Welcome.vue file in js/Pages.
- Replaced the default web.php routes file with a slightly modified version to return an Intertia instance.

### Fixed
- Fixed a bug parsing the integer port number.
- Fixed an odd bug in the dev server running test that.
- Fixed a bug in the dev server command that was getting the wrong host.

## [0.4.0] 2022-01-31
### Added
- Added support for a custom port number to be set.
- Added a new `vitamin:serve` Artisan command to replace the direct call to `npx vite serve`.
- Change to an HTTP HEAD request instead of a GET request when checking if the dev server is running.

## [0.3.1] 2022-01-27
- Laravel 9+ support.

## [0.3.0] 2022-01-21
### Fixed
- Fixed a bug in `NodeDependencyInstaller` that was throwing an error when running `yarn`.
- Fixed a bug in `InertiaInstaller` that wasn't placing the middleware in `Kernel` correctly.

### Changed
- The installer classes array has been moved into the `vitamin` config file.
- Lots of refactoring to help with new tests.

## [0.2.0] 2022-01-09
### Changed
- Tailwind 3 configuration.
- Refactored the installer system.

## [0.1.4] 2021-12-01
### Added
- Added support for HTTPS. Use `vite-plugin-mkcert` to generate certificates.

## [0.1.3] 2021-11-30
### Fixed
- The `app.js` directory bug was still a problem, caused by a stupid error.

## [0.1.2] 2021-11-22
### Fixed
- The `app.js` file will be placed in the specified JavaScript directory.

## [0.1.1] 2021-11-12
### Fixed
- Installing JS files will now respect the specified directory

### Added
- The specified Inertia pages directory is created by default now.

## [0.1.0] 2021-10-27
### Added
- Added a `vitamin.php` config file. Just so you can specify the view composer class.

## [0.0.15] 2021-09-21
### Removed
- Removed the blade `@vitamin` directive as it's causing problems as Laravel's blade cache.

## [0.0.14] 2021-09-20
### Added
- Added a `@vitamin` blade directive instead of the `{!! $vitamin !! }` thing. Although it does require a cache reset when either building or running the dev server.
- Fixed a bug in the new `Vitamin` class that was returning the incorrect element when linking to the CSS.

## [0.0.13] 2021-08-23
### Fixed
- Fixed a typo in the "@" alias set in `vite.config.js`.

## [0.0.11] 2021-08-20
### Changed
- The init command will no longer ask for a "components" path.

### Added
- The Inertia installer will add the `HandleInertiaRequests` middleware to the `Kernel.php` file.
- Removed the execution timeout from a number of processes.

## [0.0.10] 2021-08-18
### Fixed
- Fixed a bug not installing node dependencies correctly.
### Changed
- Init command will now ask for a components path.

## [0.0.9] 2021-08-18
### Fixed
- Fixed a bug in the `LocalValetDriver` that was not loading static files correctly.

## [0.0.8] 2021-08-18
### Changed
- Node dependencies are now added as dev dependencies.
- Updated the `README` to include a section on the view composer and how to extend it.

## [0.0.7] 2021-08-18
### Added
- The `AppComposer` class now has a protected `$jsPath` property that points to the `app.js` location. This makes it easier to extend. 

## [0.0.6] 2021-08-18
### Fixed
- Init command will now ask for a JS sources path.
- Fixed a path bug when specifying the JS path in `jsconfig.json` and `vite.config.js`.
- Init command will now strip slashes from provided paths.

## [0.0.5] 2021-08-18
### Fixed
- Fixed a bug in the `app.js` stub that was including the Vue path incorrectly.

## [0.0.4] 2021-08-18
### Added
- Remove the original `webpack.mix.js` file as it's no longer needed.
