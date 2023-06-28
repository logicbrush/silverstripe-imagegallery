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
sidebar.  Add it to your WidgetArea and select the gallery you wish to display.


## Configuration

Select which column to sort the images by, via the "Sort By" dropdown.
Selecting "Newest First" will sort the images by "Created" in DESC order.
Selecting "Position" will sort the images by "SortOrder" in ASC order.

Reordering the images manually will only have effect if "Position" is selected.
