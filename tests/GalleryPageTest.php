<?php

namespace Logicbrush\ImageGallery\Tests;

use SilverStripe\Dev\FunctionalTest;

class GalleryPageTest extends FunctionalTest
{
	protected $usesDatabase = true;

	public function testCanCreateGalleryPageTest() {
		$amenityPage = GalleryPage::create();
		$amenityPage->write();

		$this->assertEquals( 1, GalleryPage::get()->count() );
	}


	public function testDisplayingGalleryPage() {
		$amenityPage = GalleryPage::create( [
				'Title' => 'Gallery Page',
				'Content' => '<p>Gallery</p>',
			] );
		$amenityPage->write();
		$amenityPage->publish( 'Stage', 'Live' );

		$response = $this->get( $amenityPage->Link() );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertPartialMatchBySelector( 'h1', [
				'Gallery Page',
			] );
	}


	public function testGetCMSFields() {
		$amenityPage = GalleryPage::create();
		$amenityPage->write();

		$fields = $amenityPage->getCMSFields();
		$this->assertNotNull( $fields );
	}


	public function testGetOGImage() {
		$amenityPage = GalleryPage::create();
		$amenityPage->write();

		$this->assertNull( $amenityPage->getOGImage() );

		$image1 = FakeImage::create();
		$image1->write();

		$image2 = FakeImage::create();
		$image2->write();

		$amenityPage->Images()->add( $image1, ['SortOrder' => 2] );
		$amenityPage->Images()->add( $image2, ['SortOrder' => 1] );

		$this->assertNotNull( $amenityPage->getOGImage() );
		$this->assertEquals( $image2->ID, $amenityPage->getOGImage()->ID );

		$amenityPage->Images()->add( $image1, ['SortOrder' => 1] );
		$amenityPage->Images()->add( $image2, ['SortOrder' => 2] );

		$this->assertNotNull( $amenityPage->getOGImage() );
		$this->assertEquals( $image1->ID, $amenityPage->getOGImage()->ID );
	}


}
