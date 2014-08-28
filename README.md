## transi

[![Codeship Status for gyKa/transi](https://www.codeship.io/projects/72b86db0-0c02-0132-b895-1a6ea54ccc5e/status)](https://www.codeship.io/projects/32092)
[![Dependency Status](https://www.versioneye.com/user/projects/53ee6f0f13bb06f7cc000330/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53ee6f0f13bb06f7cc000330)

### System requirements

* PHP 5.4 (or later)
* MySQL

### Available commands

`make install` - installation for production

`make dev-install` - installation for development

`make update` - updates source, libraries and runs migrations for production

`make codeship` - prepare environment for CodeShip.

### Code quality assurance

`make phpmd` - runs PHP Mess Detector

`make phpcs` - runs PHP CodeSniffer

`make check` - runs above commands in sequence
