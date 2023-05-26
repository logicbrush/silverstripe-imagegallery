<?php
/**
 * tests/GalleryPageTest.php
 *
 * @package default
 */


namespace Logicbrush\ImageGallery\Tests;

use Logicbrush\ImageGallery\Model\GalleryPage;
use SilverStripe\Dev\FunctionalTest;

class GalleryPageTest extends FunctionalTest
{
	protected $usesDatabase = true;

	/**
	 *
	 */
	public function testCanCreateGalleryPageTest() {
		$galleryPage = GalleryPage::create();
		$galleryPage->write();

		$this->assertEquals( 1, GalleryPage::get()->count() );
	}


	/**
	 *
	 */
	public function testDisplayingGalleryPage() {
		$galleryPage = GalleryPage::create( [
				'Title' => 'Gallery Page',
				'Content' => '<p>Gallery</p>',
			] );
		$galleryPage->write();
		$galleryPage->publish( 'Stage', 'Live' );

		$response = $this->get( $galleryPage->Link() );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringNotContainsString( 'image-gallery', $response->getBody() );

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
		$galleryPage->write();
		$galleryPage->publish( 'Stage', 'Live' );

		$response = $this->get( $galleryPage->Link() );
		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'image-gallery', $response->getBody() );
	}


	/**
	 *
	 */
	public function testGetCMSFields() {
		$galleryPage = GalleryPage::create();
		$galleryPage->write();

		$fields = $galleryPage->getCMSFields();
		$this->assertNotNull( $fields );
	}


	/**
	 *
	 */
	public function testContent() {
		$galleryPage = GalleryPage::create( [
				'Title' => 'Gallery Page',
				'Content' => '<p>Gallery</p>',
			] );
		$galleryPage->write();
		$galleryPage->publish( 'Stage', 'Live' );

		$content = $galleryPage->GalleryContent();
		$this->assertStringNotContainsString( 'image-gallery', $content );

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
		$galleryPage->write();
		$galleryPage->publish( 'Stage', 'Live' );

		$content = $galleryPage->GalleryContent();
		$this->assertStringContainsString( 'image-gallery', $content );
	}


	/**
	 *
	 */
	public function testGetOGImage() {
		$galleryPage = GalleryPage::create();
		$galleryPage->write();

		$this->assertNull( $galleryPage->getOGImage() );

		$image1 = FakeImage::create();
		$image1->write();

		$image2 = FakeImage::create();
		$image2->write();

		$galleryPage->Images()->add( $image1, ['SortOrder' => 2] );
		$galleryPage->Images()->add( $image2, ['SortOrder' => 1] );

		$this->assertNotNull( $galleryPage->getOGImage() );
		$this->assertEquals( $image2->ID, $galleryPage->getOGImage()->ID );

		$galleryPage->Images()->add( $image1, ['SortOrder' => 1] );
		$galleryPage->Images()->add( $image2, ['SortOrder' => 2] );

		$this->assertNotNull( $galleryPage->getOGImage() );
		$this->assertEquals( $image1->ID, $galleryPage->getOGImage()->ID );
	}


}
