<?php

namespace Mouf\Utils\Cache\Purge\Admin\Controllers;

use Mouf\InstanceProxy;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\ClassProxy;
use Mouf\Utils\Cache\Purge\Service\PurgeCacheService;

/**
 * The controller to purge all caches.
 *
 * @Component
 */
class PurgeCacheController extends Controller
{
    /**
     * The default template to use for this controller (will be the mouf template).
     *
     * @Property
     * @Compulsory
     *
     * @var TemplateInterface
     */
    public $template;

    /**
     * @var HtmlBlock
     */
    public $content;

    protected $selfedit;
    protected $done;
    protected $name;

    /**
     * Admin page used to purge all caches.
     *
     * @Action
     * @Logged
     */
    public function defaultAction($selfedit = 'false', $done = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCacheGlobalPurgeAllCachesMenuItem');
        $menu->setIsActive(true);

        $this->selfedit = $selfedit;
        $this->done = $done;
        $this->content->addFile(__DIR__.'/../../../../../../views/purge.php', $this);
        $this->template->toHtml();
    }

    /**
     * Admin page used to purge a single instance.
     *
     * @URL /purgePSR6CacheInstance/
     * @Logged
     */
    public function purgePsr6CacheInstance($name, $selfedit = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePurgeOnePsr6CacheMenuItem');
        $menu->setIsActive(true);
        $this->name = $name;
        $cacheService = new InstanceProxy($name, $selfedit == 'true');
        $cacheService->clear();

        $this->selfedit = $selfedit;
        $this->content->addFile(__DIR__.'/../../../../../../views/purgeInstanceDone.php', $this);
        $this->template->toHtml();
    }

    /**
     * Admin page used to purge a single instance.
     *
     * @URL /purgePSR16CacheInstance/
     * @Logged
     */
    public function purgePsr16CacheInstance($name, $selfedit = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePurgeOnePsr16CacheMenuItem');
        $menu->setIsActive(true);
        $this->name = $name;
        $cacheService = new InstanceProxy($name, $selfedit == 'true');
        $cacheService->clear();

        $this->selfedit = $selfedit;
        $this->content->addFile(__DIR__.'/../../../../../../views/purgeInstanceDone.php', $this);
        $this->template->toHtml();
    }

    /**
     * Admin page used to purge a single instance.
     *
     * @URL /purgeDoctrineCacheInstance/
     * @Logged
     */
    public function purgeDoctrineCacheInstance($name, $selfedit = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePurgeOneDoctrineCacheMenuItem');
        $menu->setIsActive(true);
        $this->name = $name;
        $cacheService = new InstanceProxy($name, $selfedit == 'true');
        $cacheService->deleteAll();

        $this->selfedit = $selfedit;
        $this->content->addFile(__DIR__.'/../../../../../../views/purgeInstanceDone.php', $this);
        $this->template->toHtml();
    }

    /**
     * Admin page used to purge a single instance.
     *
     * @URL /purgeMoufCacheInstance/
     * @Logged
     */
    public function purgeMoufCacheInstance($name, $selfedit = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePurgeOneMoufCacheMenuItem');
        $menu->setIsActive(true);
        $this->name = $name;
        $cacheService = new InstanceProxy($name, $selfedit == 'true');
        $cacheService->purgeAll();

        $this->selfedit = $selfedit;
        $this->content->addFile(__DIR__.'/../../../../../../views/purgeInstanceDone.php', $this);
        $this->template->toHtml();
    }

    /**
     * Admin page used to purge a single instance.
     *
     * @URL /purgePurgeableCacheInstance/
     * @Logged
     */
    public function purgePurgeableCacheInstance($name, $selfedit = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePurgeOnePurgeableCacheMenuItem');
        $menu->setIsActive(true);
        $this->name = $name;
        $cacheService = new InstanceProxy($name, $selfedit == 'true');
        $cacheService->purge();

        $this->selfedit = $selfedit;
        $this->content->addFile(__DIR__.'/../../../../../../views/purgeInstanceDone.php', $this);
        $this->template->toHtml();
    }

    /**
     * Finds all the instances implementing the CacheInterface, and calls the "purge" method on them.
     *
     * @Action
     *
     * @param string $selfedit
     */
    public function purge($selfedit = 'false')
    {
        $this->doPurge($selfedit);

        header('Location: .?done=true&selfedit='.urlencode($selfedit));
    }

    /**
     * Finds all the instances implementing the CacheInterface, and calls the "purge" method on them.
     *
     * @Action
     *
     * @param string $selfedit
     */
    public function doPurge($selfedit = 'false')
    {
        $purgeCacheService = new ClassProxy(PurgeCacheService::class);
        $purgeCacheService->purgeAll();
    }
}
