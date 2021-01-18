# Resource Hints for Magento 2

## Overview

Add `<link rel='preconnect'>`, `<link rel='prefetch'>` or `<link rel='preload'>` resource hints to Magento 2's head.

## Features

- Tweak your Magento 2 store's performance by adding custom `preconnect`, `prefetch` and `preload` headers.
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

#### Resource

Values added to this field are assumed to be relative local assets. Their full url will be automatically resolved prior to render:

- `Vendor_Module::path/to/asset.ext` (local)
- `path/to/asset.ext` (local)

Because of this, remote assets **must** be prefixed with a protocol:
- `http://domain.tld/path/to/asset.ext` (remote)
- `https://domain.tld/path/to/asset.ext` (remote)
- `//SomeVolume/path/to/asset.ext` (remote)
