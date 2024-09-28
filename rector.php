<?php


declare( strict_types = 1 );

use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function ( RectorConfig $rectorConfig ): void {

	$rectorConfig->sets( [
			LevelSetList::UP_TO_PHP_74,
			SetList::CODE_QUALITY,
			SetList::DEAD_CODE,
		] );

	$rectorConfig->skip( [
			CompleteDynamicPropertiesRector::class,
			ExplicitBoolCompareRector::class,
			RemoveParentCallWithoutParentRector::class,
			RemoveUnusedPrivatePropertyRector::class,
		] );

	$rectorConfig->importShortClasses();
	$rectorConfig->importNames();

};
