## transi

[![Codeship Status for gyKa/transi](https://www.codeship.io/projects/72b86db0-0c02-0132-b895-1a6ea54ccc5e/status)](https://www.codeship.io/projects/32092)
[![Build Status](https://travis-ci.org/gyKa/transi.svg?branch=master)](https://travis-ci.org/gyKa/transi)
[![Dependency Status](https://www.versioneye.com/user/projects/53ee6f0f13bb06f7cc000330/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53ee6f0f13bb06f7cc000330)

### System requirements

* PHP 5.4 (or later)
* PHP-CLI
* MySQL or PostgreSQL
* Apache 2 or Nginx
* Composer
* cURL (optional, for downloading Composer only)
* Make (optional, but highly recommended)
* Vagrant (optional, for development only)

### Available commands

`make install` - installation for production

`make dev-install` - installation for development

`make update` - updates source, libraries and runs migrations for production

`make codeship` - prepare environment for CodeShip.

`make travis` - prepare environment for Travis.

### Code quality assurance

`make phpmd` - runs PHP Mess Detector

`make phpcs` - runs PHP CodeSniffer

`make phpcpd` - runs PHP Copy/Paste Detector

`make check` - runs above commands in sequence
