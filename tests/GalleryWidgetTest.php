<?php

namespace Logicbrush\ImageGallery\Tests;

use Logicbrush\ImageGallery\Model\GalleryWidget;
use Logicbrush\ImageGallery\Model\GalleryWidgetController;
use Logicbrush\ImageGallery\Model\GalleryPage;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Widgets\Model\WidgetArea;

class GalleryWidgetTest extends FunctionalTest
{
	protected $usesDatabase = true;

	public function testCanCreateGalleryWidgetTest() {
		$galleryWidget = GalleryWidget::create();
		$galleryWidget->write();

		$this->assertEquals( 1, GalleryWidget::get()->count() );
	}


	public function testGetCMSFields() {
		$galleryWidget = GalleryWidget::create();
		$galleryWidget->write();

		$fields = $galleryWidget->getCMSFields();
		$this->assertNotNull( $fields );
	}


	public function testContent() {
		$galleryPage = GalleryPage::create();
		$galleryPage->Title = 'Gallery Page';
		$galleryPage->Content = '<p>Gallery</p>';
		$galleryPage->write();
		$galleryPage->publish( 'Stage', 'Live' );

		$galleryWidget = GalleryWidget::create();
		$galleryWidget->write();

		$galleryWidgetController = GalleryWidgetController::create($galleryWidget);
		$galleryWidgetController->write();

		$this->assertNull( $galleryWidgetController->Images() );

		$galleryWidget->GalleryPageID = $galleryPage->ID;
		$galleryWidget->write();

		$this->assertEquals( 0, $galleryWidgetController->Images()->count() );

		$image1 = FakeImage::create();
		$image1->Filename = 'image1.jpg';
		$image1->write();
		$image1->publish( 'Stage', 'Live' );

		$image2 = FakeImage::create();
		$image2->Filename = 'image2.jpg';
		$image2->write();
		$image2->publish( 'Stage', 'Live' );

		$galleryPage->Images()->add( $image1, ['SortOrder' => 1] );
		$galleryPage->Images()->add( $image2, ['SortOrder' => 2] );

		$this->assertEquals( 2, $galleryWidgetController->Images()->count() );

		$galleryWidget->ImagesCount = 1;
		$galleryWidget->write();

		$this->assertEquals( 1, $galleryWidgetController->Images()->count() );
	}


}
