<?php

namespace Logicbrush\ImageGallery\Tests;

use SilverStripe\Assets\Image;

class FakeImage extends Image {

	public function exists() {
		return true;
	}


}
