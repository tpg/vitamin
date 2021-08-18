# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.0.8]
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
