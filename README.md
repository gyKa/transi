## transi

[![Codeship Status for gyKa/transi](https://www.codeship.io/projects/72b86db0-0c02-0132-b895-1a6ea54ccc5e/status)](https://www.codeship.io/projects/32092)
[![Build Status](https://travis-ci.org/gyKa/transi.svg?branch=master)](https://travis-ci.org/gyKa/transi)
[![Dependency Status](https://www.versioneye.com/user/projects/53ee6f0f13bb06f7cc000330/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53ee6f0f13bb06f7cc000330)

### System requirements

* PHP 5.5 (or later)
* PHP-CLI
* MySQL or PostgreSQL
* Apache 2 or Nginx
* Composer
* Bower
* cURL (optional, for downloading Composer only)
* Make (optional, but highly recommended)
* Vagrant (optional, for development only)

### Installation

#### Heroku

Add multipack build option:

`heroku config:add BUILDPACK_URL=https://github.com/ddollar/heroku-buildpack-multi.git`

#### Vagrant

After installation, GIT requires to setup environment. Run following lines:

`git config --global user.email "your@email.com"`
`git config --global user.name "Firstname Lastname"`

There exist 2 problems I can't solve:

* NPM fails to run _postinstall_ script while Heroku works well. Need to run:

`cd /vagrant && npm install`

* PostgreSQL fails to change directory /root for unknown reason. But works well.

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

`make phploc` - runs a tool for quickly measuring the size and analyzing the structure of a PHP project
