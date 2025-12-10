<?php


declare( strict_types = 1 );

use Cambis\SilverstripeRector\CodeQuality\Rector\Assign\ConfigurationPropertyFetchToMethodCallRector;
use Cambis\SilverstripeRector\CodeQuality\Rector\StaticPropertyFetch\StaticPropertyFetchToConfigGetRector;
use Cambis\SilverstripeRector\Set\ValueObject\SilverstripeLevelSetList;
use Cambis\SilverstripeRector\Set\ValueObject\SilverstripeSetList;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function ( RectorConfig $rectorConfig ): void {

	$rectorConfig->sets( [
			SilverstripeLevelSetList::UP_TO_SILVERSTRIPE_60,
			SilverstripeSetList::CODE_QUALITY,
			LevelSetList::UP_TO_PHP_83,
			SetList::CODE_QUALITY,
			SetList::DEAD_CODE,
		] );

	$rectorConfig->skip( [
			AddOverrideAttributeToOverriddenMethodsRector::class,	
			CompleteDynamicPropertiesRector::class,
			ExplicitBoolCompareRector::class,
			RemoveParentCallWithoutParentRector::class,
			RemoveUnusedPrivatePropertyRector::class,
		] );

	$rectorConfig->importShortClasses();
	$rectorConfig->importNames();

};
