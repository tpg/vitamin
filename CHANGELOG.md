# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.5] 2022-01-09
### Changed
- Tailwind 3 configuration.

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
