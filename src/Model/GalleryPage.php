<?php

namespace Logicbrush\ImageGallery\Model;

use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Tab;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

class GalleryPage extends \Page {

	private static $icon = 'logicbrush/silverstripe-imagegallery:images/treeicons/gallery-page.png';
	private static $description = 'An image gallery.';
	private static $singular_name = 'Gallery Page';
	private static $plural_name = 'Gallery Pages';
	private static $table_name = 'GalleryPage';

	private static $many_many = [
		'Images' => Image::class,
	];

	private static $many_many_extraFields = [
		'Images' => [
			'SortOrder' => 'Int',
		],
	];

	private static $owns = [
		'Images',
	];

	public static function requirements() {

		// Third-party javascripts.
		Requirements::javascript('logicbrush/silverstripe-imagegallery:thirdparty/photoswipe.min.js');
		Requirements::javascript('logicbrush/silverstripe-imagegallery:thirdparty/photoswipe-ui-default.min.js');
		Requirements::javascript('logicbrush/silverstripe-imagegallery:thirdparty/slick.min.js');

		// Third-party css.
		Requirements::css('logicbrush/silverstripe-imagegallery:thirdparty/photoswipe.css');
		Requirements::css('logicbrush/silverstripe-imagegallery:thirdparty/photoswipe-default-skin/default-skin.css');
		Requirements::css('logicbrush/silverstripe-imagegallery:thirdparty/slick.css');

		// Our scripts.
		Requirements::javascript('logicbrush/silverstripe-imagegallery:javascript/photoswipe.js', [ 'defer' => true ]);
		Requirements::javascript('logicbrush/silverstripe-imagegallery:javascript/gallery-page.js', [ 'defer' => true ]);

	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter( 'Main', Tab::create( 'Gallery' ) );

		$fields->addFieldToTab( 'Root.Gallery', $imageField = SortableUploadField::create( 'Images', 'Images' ) );
		$imageField->setFolderName( 'gallery' );

		return $fields;
	}


	public function SortedImages() {
		$images = $this->Images();
		foreach ($this->AllChildren() as $child) {
			if ($child instanceof GalleryPage) {
				$images->addMany($child->SortedImages());
			}
		}
		return $images->sort( ['SortOrder' => 'ASC'] );
	}


	public function getOGImage() {

		foreach ( $this->SortedImages() as $image ) {
			if ( $image->exists() ) {
				return $image;
			}
		}

		if ( ClassInfo::hasMethod( Injector::inst()->get( 'Page' ), 'getOGImage' ) ) {
			return parent::getOGImage();
		}

	}

	public function Content() {

		self::requirements();

		$content = $this->Content;

		if ($this->SortedImages()) {
			$template = new SSViewer('Logicbrush/ImageGallery/Includes/GalleryPageContent');

			$data = [
				'Images' => $this->SortedImages(),
			];

			$content .= $template->process($this->controller, $data);
		}

		return $content;
	}

}


class GalleryPageController extends \PageController {

	public function init() {
		parent::init();

	}


}
