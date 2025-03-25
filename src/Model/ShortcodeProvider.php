<?php

namespace Logicbrush\ImageGallery\Model;

use SilverStripe\View\ArrayData;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\Parsers\ShortcodeParser;

class ShortcodeProvider implements ShortcodeHandler {

	/**
	 *
	 * @Metrics( crap = 2, uncovered = true )
	 */


	public static function get_shortcodes() {
		return [ 'image_gallery' ];
	}


	/**
	 * [ image_gallery id=n ]
	 *
	 *
	 * @Metrics( crap = 20, uncovered = true )
	 * @param array           $arguments
	 * @param string          $content
	 * @param ShortcodeParser $parser
	 * @param string          $shortcode
	 * @param array           $extra
	 * @return string
	 */
	public static function handle_shortcode( $arguments, $content, $parser, $shortcode, $extra = [] ) {

		if ( ! isset( $arguments['id'] ) || ! ( $pageID = $arguments['id'] ) ) {
			return '';
		}

		if ( ! ( $page = GalleryPage::get()->byID( $pageID ) ) ) {
			return '';
		}

		return ArrayData::create( [
				'GalleryPage' => $page,
				'Images' => $page->SortedImages(),
			] )->renderWith( 'Logicbrush/ImageGallery/Model/GalleryShortcode' );

	}


}
