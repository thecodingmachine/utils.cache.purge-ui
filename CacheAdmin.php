<?php

use Doctrine\Common\Cache\ClearableCache;
use Mouf\Html\HtmlElement\HtmlFromFile;
use Mouf\MoufManager;
use Mouf\MoufUtils;
use Mouf\Utils\Cache\Purge\PurgeableInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;

// Because cache-interface can be used in both the application and in Mouf admin, there are 2
// PurgeCacheController classes. We must be sure to load the right one.
// So instead of relying on the autoloader that will favor the class in Mouf admin, we force the
// loading of the class.
require_once 'src/Mouf/Utils/Cache/Purge/Admin/Controllers/PurgeCacheController.php';

MoufUtils::registerMainMenu('utilsMainMenu', 'Utils', null, 'mainMenu', 200);
MoufUtils::registerMenuItem('utilsCacheInterfaceMenu', 'Cache management', null, 'utilsMainMenu', 50);
MoufUtils::registerMenuItem('utilsCacheGlobalPurgeAllCachesMenuItem', 'Purge all cache pools', 'purgeGlobalCaches/', 'utilsCacheInterfaceMenu', 10);
if (file_exists(__DIR__.'/../../psr/cache')) {
    MoufUtils::registerChooseInstanceMenuItem('utilsCachePurgeOnePsr6CacheMenuItem', 'Purge a PSR-6 cache instance', 'purgePSR6CacheInstance/', CacheItemPoolInterface::class, 'utilsCacheInterfaceMenu', 10);
}
if (file_exists(__DIR__.'/../../psr/simple-cache')) {
    MoufUtils::registerChooseInstanceMenuItem('utilsCachePurgeOnePsr16CacheMenuItem', 'Purge a PSR-16 cache instance', 'purgePSR16CacheInstance/', CacheInterface::class, 'utilsCacheInterfaceMenu', 20);
}
if (file_exists(__DIR__.'/../../doctrine/cache')) {
    MoufUtils::registerChooseInstanceMenuItem('utilsCachePurgeOneDoctrineCacheMenuItem', 'Purge a Doctrine cache instance', 'purgeDoctrineCacheInstance/', ClearableCache::class, 'utilsCacheInterfaceMenu', 30);
}
if (file_exists(__DIR__.'/../../mouf/utils.cache.cache-interface')) {
    MoufUtils::registerChooseInstanceMenuItem('utilsCachePurgeOneMoufCacheMenuItem', 'Purge a Mouf cache instance', 'purgeMoufCacheInstance/', \Mouf\Utils\Cache\CacheInterface::class, 'utilsCacheInterfaceMenu', 40);
}
MoufUtils::registerChooseInstanceMenuItem('utilsCachePurgeOnePurgeableCacheMenuItem', 'Purge a PurgeableInterface cache instance', 'purgePurgeableCacheInstance/', PurgeableInterface::class, 'utilsCacheInterfaceMenu', 50);

$moufManager = MoufManager::getMoufManager();
$navbar = $moufManager->getInstance("navBar");
$navbar->children[] = new HtmlFromFile("../../../vendor/mouf/utils.cache.purge-ui/src/views/purgebutton.php");

// Controller declaration
$moufManager->declareComponent('purgeGlobalCaches', 'Mouf\\Utils\\Cache\\Purge\\Admin\\Controllers\\PurgeCacheController', true);
$moufManager->bindComponents('purgeGlobalCaches', 'template', 'moufTemplate');
$moufManager->bindComponents('purgeGlobalCaches', 'content', 'block.content');


unset($moufManager);
