<?php
/**
 * tests/FakeImage.php
 *
 * @package default
 */


namespace Logicbrush\ImageGallery\Tests;

use SilverStripe\Assets\Image;

class FakeImage extends Image {

	/**
	 *
	 * @return unknown
	 */
	public function exists() {
		return true;
	}


}
