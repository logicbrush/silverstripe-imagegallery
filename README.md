# silverstripe-imagegallery

[![Build Status](https://travis-ci.org/logicbrush/silverstripe-imagegallery.svg?branch=master)](https://travis-ci.org/logicbrush/silverstripe-imagegallery)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/logicbrush/silverstripe-imagegallery/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/logicbrush/silverstripe-imagegallery/?branch=master)
[![codecov.io](https://codecov.io/github/logicbrush/silverstripe-imagegallery/coverage.svg?branch=master)](https://codecov.io/github/logicbrush/silverstripe-imagegallery?branch=master)

A module for the SilverStripe CMS which allows you to display a bunch of images
in a gallery format.

## Why?

We needed a simple way to present a set of images that can be easily navigated
on any device.

## Installation

```sh
composer require "logicbrush/silverstripe-imagegallery"
```

## Usage

Install the module and you'll have a new page type of "Gallery Page".  You can
add and reorder images to the page from the "Images" tab in the CMS.

In addition, this module provides a widget for displaying a gallery in a
sidebar.  Add it to your WidgetArea and select the gallery you wish to display.
