<?php

namespace Logicbrush\ImageGallery\Model;

use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Forms\Tab;
use SilverStripe\View\Requirements;


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
		return $this->Images()->Sort( 'SortOrder' );
	}


	public function getOGImage() {

		foreach ( $this->SortedImages() as $image ) {
			if ( $image->exists() ) {
				return $image;
			}
		}

		foreach ( class_parents( $this ) as $parent ) {
			if ( ClassInfo::hasMethod( $parent, $method = __METHOD__ ) ) {
				return parent::$method();
			}
		}

	}

	public function Content() {

		self::requirements();

		$content = $this->Content;

		if ($this->Images()) {
			$pos = 0;
			$content .= "<div class='image-gallery' itemscope itemtype='http://schema.org/ImageGallery'>";
			foreach($this->SortedImages() as $image) {
				$content .= "<figure class='item' itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject' data-index='{$pos}'>";
				$content .= "<a href='{$image->FitMax(2000,2000)->URL}' itemprop='contentUrl' data-width='{$image->FitMax(1000,1000)->Width}' data-height='{$image->FitMax(1000,1000)->Height}' data-index='{$pos}' aria-label='{$this->he($image->Title)}'>";
				$content .= "<img src='{$image->FocusFill(480,480)->URL}' width='480' height='480' itemprop='thumbnail' alt='{$this->he($image->Title)}' />";
				$content .= "</a>";
				$content .= "</figure>";
				++$pos;
			}
			$content .= "</div>";
		}

		return $content;
	}

	private function he($str) {
		return htmlentities($str);
	}

}


class GalleryPageController extends \PageController {

	public function init() {
		parent::init();

	}


}
