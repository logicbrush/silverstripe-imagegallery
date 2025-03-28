<?php
/**
 * src/Model/GalleryPage.php
 *
 * @package default
 */


namespace Logicbrush\ImageGallery\Model;

use Page;
use PageController;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\Tab;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

class GalleryPage extends Page {

	private static $icon = 'logicbrush/silverstripe-imagegallery:images/treeicons/gallery-page.png';
	private static $description = 'An image gallery.';
	private static $singular_name = 'Gallery Page';
	private static $plural_name = 'Gallery Pages';
	private static $table_name = 'GalleryPage';

	private static $db = [
		'SortBy' => "Enum('Position, Newest First', 'Position')",
	];

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

	/**
	 *
	 * @Metrics( crap = 1 )
	 */
	public static function requirements() {

		// Third-party javascripts.
		Requirements::javascript( 'logicbrush/silverstripe-imagegallery:thirdparty/photoswipe.min.js' );
		Requirements::javascript( 'logicbrush/silverstripe-imagegallery:thirdparty/photoswipe-ui-default.min.js' );
		Requirements::javascript( 'logicbrush/silverstripe-imagegallery:thirdparty/slick.min.js' );

		// Third-party css.
		Requirements::css( 'logicbrush/silverstripe-imagegallery:thirdparty/photoswipe.css' );
		Requirements::css( 'logicbrush/silverstripe-imagegallery:thirdparty/photoswipe-default-skin/default-skin.css' );
		Requirements::css( 'logicbrush/silverstripe-imagegallery:thirdparty/slick.css' );

		// Our scripts.
		Requirements::javascript( 'logicbrush/silverstripe-imagegallery:javascript/photoswipe.js', [ 'defer' => true ] );
		Requirements::javascript( 'logicbrush/silverstripe-imagegallery:javascript/gallery-page.js', [ 'defer' => true ] );

	}


	/**
	 *
	 * @Metrics( crap = 1 )
	 * @return unknown
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter( 'Main', Tab::create( 'Gallery' ) );
		$fields->addFieldToTab( 'Root.Gallery', $imageField = SortableUploadField::create( 'Images', 'Images' ) );
		$imageField->setFolderName( 'gallery' );

		$fields->insertBefore(
			'Images',
			DropdownField::create( 'SortBy', 'Sort By', singleton( GalleryPage::class )->dbObject( 'SortBy' )->enumValues() )
		);

		return $fields;
	}


	/**
	 *
	 * @Metrics( crap = 4.59 )
	 * @return unknown
	 */
	public function SortedImages() {
		$images = $this->Images();
		foreach ( $this->AllChildren() as $child ) {
			if ( $child instanceof GalleryPage ) {
				$images->addMany( $child->SortedImages() );
			}
		}
		$sort = ( $this->SortBy == 'Newest First' ) ? ['Created' => 'DESC'] : ['SortOrder' => 'ASC'];
		return $images->sort( $sort );
	}


	/**
	 *
	 * @Metrics( crap = 4.07 )
	 * @return unknown
	 */
	public function getOGImage() {

		foreach ( $this->SortedImages() as $image ) {
			if ( $image->exists() ) {
				return $image;
			}
		}

		if ( ClassInfo::hasMethod( Injector::inst()->get( 'Page' ), 'getOGImage' ) ) {
			return parent::getOGImage();
		}
		return null;

	}


	/**
	 *
	 * @Metrics( crap = 2.01 )
	 * @return unknown
	 */
	public function GalleryContent() : ?string {

		self::requirements();

		if ( $this->SortedImages() ) {
			$template = new SSViewer( 'Logicbrush/ImageGallery/Includes/GalleryPageContent' );

			$data = [
				'Images' => $this->SortedImages(),
			];

			return $template->process( $this->controller, $data );
		}

		return null;
	}


}


class GalleryPageController extends PageController {

	/**
	 *
	 * @Metrics( crap = 1 )
	 * @return unknown
	 */
	public function index() {
		return [
			'Content' => DBField::create_field(
				'HTMLText',
				$this->Content . $this->GalleryContent()
			),
		];
	}


}
