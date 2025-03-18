<?php

use Logicbrush\ImageGallery\Model\ShortcodeProvider;
use SilverStripe\View\Parsers\ShortcodeParser;

// Register 'image_gallery' shortcode.
$parser = ShortcodeParser::get('default');
$parser->register( 'image_gallery', [ ShortcodeProvider::class, 'handle_shortcode' ] );
