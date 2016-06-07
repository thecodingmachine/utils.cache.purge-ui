<?php

use Mouf\Html\HtmlElement\HtmlFromFile;
use Mouf\MoufManager;
use Mouf\MoufUtils;

// Because cache-interface can be used in both the application and in Mouf admin, there are 2
// PurgeCacheController classes. We must be sure to load the right one.
// So instead of relying on the autoloader that will favor the class in Mouf admin, we force the
// loading of the class.
require_once 'src/Mouf/Utils/Cache/Psr/Admin/Controllers/PurgeCacheController.php';

MoufUtils::registerMainMenu('utilsMainMenu', 'Utils', null, 'mainMenu', 200);
MoufUtils::registerMenuItem('utilsCacheInterfaceMenu', 'Cache management', null, 'utilsMainMenu', 50);
MoufUtils::registerMenuItem('utilsCachePsr6PurgeAllCachesMenuItem', 'Purge all PSR-6 cache pools', 'purgePsr6Caches/', 'utilsCacheInterfaceMenu', 10);
MoufUtils::registerChooseInstanceMenuItem('utilsCachePsr6PurgeOneCacheMenuItem', 'Purge a PSR-6 cache pool instance', 'purgePsr6CacheInstance/', 'Psr\\Cache\\CacheItemPoolInterface', 'utilsCacheInterfaceMenu', 10);

$moufManager = MoufManager::getMoufManager();
$navbar = $moufManager->getInstance("navBar");
$navbar->children[] = new HtmlFromFile("../../../vendor/mouf/utils.cache.psr6-ui/src/views/purgebutton.php");

// Controller declaration
$moufManager->declareComponent('purgePsr6Caches', 'Mouf\\Utils\\Cache\\Admin\\Psr\\Controllers\\PurgeCacheController', true);
$moufManager->bindComponents('purgePsr6Caches', 'template', 'moufTemplate');
$moufManager->bindComponents('purgePsr6Caches', 'content', 'block.content');


unset($moufManager);
