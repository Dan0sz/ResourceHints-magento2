# THIS EXTENSION IS NO LONGER ACTIVELY MAINTAINED

If it doesn't work on your Magento 2 instance, please fork this repo and fix it -- and feel free to submit a PR to add your changes to this repo.

Update January 31st, 2022: I've removed the Magento version requirements from composer.json so that you can try it on any instance. I'm not guaranteeing it'll work.

# Resource Hints for Magento 2

## Overview

Add `<link rel='preconnect'>`, `<link rel='dns-prefetch'>`, `<link rel='prefetch'>`,  or `<link rel='preload'>` resource hints to Magento 2's head.

## Features

- Tweak your Magento 2 store's performance by adding custom `preconnect`, `dns-prefetch`, `prefetch`, and `preload` headers.
- Enable/disable `crossorigin` attribute.
- Easily configurable at default, website and store view level (incl. sort order).

## Installation

### Using Composer

Installation using Composer is easy and recommended. From a terminal, just run:

`composer require dan0sz/resource-hints-magento2`

### Manually

If you can't or dont want to use Composer, you can download the `master`-branch of this repository and copy the contents to `app/code/Dan0sz/ResourceHints`.

### After installation

#### Developer Mode

- Run `bin/magento setup:upgrade`
- Done!

#### Production Mode

- Run `bin/magento setup:upgrade`
- Run `bin/magento setup:di:compile`
- Run `bin/magento setup:static-content:deploy [locales e.g. en_US nl_NL]`
- Done!

## Configuration

After installation a new tab is added to *Stores > Configuration > General > Web* called *Resource Hints*.

### How does it work?

While most settings of this extension speak for themselves. The Resource column contains a few nifty tricks (thanks to @chedaroo), which will come in handy when e.g. Static content signing is enabled. 

Values in the Resource column are assumed to be relative (local) assets. When a relative path is entered and **Static Content Signing** is **enabled**, e.g. 

(*In these examples it is assumed that the default theme, Magento Luma is used.*)

- `YourName_ModuleName::path/to/file.ext` will resolve to `https://yourdomain.tld/static/<<deployment_version>>/frontend/Magento/luma/en_US/YourName_ModuleName/path/to/file.ext`, and
- `path/to/file.ext` will resolve to `https://yourdomain.tld/static/<<deployment_version>>/frontend/Magento/luma/en_US/path/to/file.ext`.

When **Static Content Signing** is **disabled**, the above mentioned values will resolve to:

- `https://yourdomain.tld/static/frontend/Magento/luma/en_US/YourName_ModuleName/path/to/file.ext`, and
- `https://yourdomain.tld/static/frontend/Magento/luma/en_US/path/to/file.ext` respectively.

When absolute URLs (prefixed by a protocol, i.e. `http://`, `https://` or `//`) are entered in the Resource column, no prior resolving will take place. E.g.

- `http://yourdomain.tld/path/to/file.ext`,
- `https://yourdomain.tld/path/to/file.ext`, and
- `//SomeVolume/path/to/file.ext`.

The examples above will all resolve to the same exact URL.
