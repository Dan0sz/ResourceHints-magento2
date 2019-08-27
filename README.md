# Resource Hints for Magento 2

## Overview

Add `<link rel='preconnect'>`, `<link rel='prefetch'>` or `<link rel='preload'>` resource hints to Magento 2's head.

## Features 

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
