<?php
/**
 * src/Model/GalleryWidget.php
 *
 * @package default
 */


namespace Logicbrush\ImageGallery\Model;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Widgets\Model\Widget;
use SilverStripe\Widgets\Model\WidgetController;

class GalleryWidget extends Widget {

	private static $title = 'Gallery';
	private static $cmsTitle = 'Gallery';
	private static $description = 'Include gallery items in your sidebar.';
	private static $table_name = 'GalleryWidget';

	private static $db = [
		'ImagesCount' => 'Int',
	];

	private static $has_one = [
		'GalleryPage' => GalleryPage::class,
	];

	private static $defaults = [
		'ImagesCount' => '4',
	];


	/**
	 *
	 * @Metrics( crap = 1 )
	 * @return unknown
	 */
	function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->push( NumericField::create( 'ImagesCount', 'Number of Images to display' ) );
		$fields->push( DropdownField::create( 'GalleryPageID', 'Gallery Page', GalleryPage::get()->map( 'ID', 'Title' ) )->setEmptyString( '' ) );

		return $fields;
	}


}


class GalleryWidgetController extends WidgetController {

	/**
	 *
	 * @Metrics( crap = 3 )
	 * @return unknown
	 */
	public function Images() {

		GalleryPage::requirements();

		if ( ! $this->GalleryPage() || ! $this->GalleryPage()->exists() ) {
			return null;
		}

		return $this->GalleryPage()->SortedImages()->limit( $this->ImagesCount );
	}


}
