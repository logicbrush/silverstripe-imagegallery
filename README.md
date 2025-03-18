# silverstripe-imagegallery

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
sidebar, and a shortcode for displaying it within an HTML block.

## General Configuration

The Gallery can be configured through the options on the "Gallery" tab in the
CMS.  

Select your images to be displayed via the"Images" field.  You can drag and drop
to reorder them.

The "Sort By" dropdown provides additional options for sorting beyond
"Position". Selecting "Newest First" will sort the images by their date of
creation in descending order order.

## Shortcode

You can insert a gallery into any HTML block using a shortcode similar to the
following:

```
[image_gallery id="{ID of GalleryPage}"]
```
