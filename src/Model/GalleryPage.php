<?php

namespace Logicbrush\ImageGallery\Model;

use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\Tab;


class GalleryPage extends \Page {

	private static $icon = 'mysite/images/treeicons/gallery-page.png';
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

		// Javascript files.
		Requirements::javascript('logicbrush/silverstripe-gallery:thirdparty/photoswipe.min.js');
		Requirements::javascript('logicbrush/silverstripe-gallery:thirdparty/photoswipe.min.js');
		Requirements::javascript('logicbrush/silverstripe-gallery:thirdparty/photoswipe-ui-default.min.js');
		Requirements::javascript('logicbrush/silverstripe-gallery:thirdparty/slick.min.js');
		Requirements::javascript('logicbrush/silverstripe-gallery:javascript/gallery-page.js');

		// CSS files.
		Requirements::css('logicbrush/silverstripe-gallery:thirdparty/photoswipe.css');
		Requirements::css('logicbrush/silverstripe-gallery:thirdparty/photoswipe-default-skin/default-skin.css');
		Requirements::css('logicbrush/silverstripe-gallery:thirdparty/slick.css');

	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter( 'Main', Tab::create( 'Gallery' ) );

		$fields->addFieldToTab( 'Root.Images', $imageField = SortableUploadField::create( 'Images', 'Images' ) );
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

		foreach(class_parents($this) as $parent){
			if(method_exists($parent, $method = __METHOD__ )) {
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
