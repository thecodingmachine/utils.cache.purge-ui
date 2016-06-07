<?php

namespace Mouf\Utils\Cache\Admin\Psr\Controllers;

use Mouf\InstanceProxy;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\ClassProxy;

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
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePsr6PurgeAllCachesMenuItem');
        $menu->setIsActive(true);

        $this->selfedit = $selfedit;
        $this->done = $done;
        $this->content->addFile(__DIR__.'/../../../../../../views/purge.php', $this);
        $this->template->toHtml();
    }

    /**
     * Admin page used to purge a single instance.
     *
     * @URL /purgePsr6CacheInstance/
     * @Logged
     */
    public function purgeCacheInstance($name, $selfedit = 'false')
    {
        $menu = MoufManager::getMoufManager()->getInstance('utilsCachePsr6PurgeOneCacheMenuItem');
        $menu->setIsActive(true);
        $this->name = $name;
        $cacheService = new InstanceProxy($name, $selfedit == 'true');
        $cacheService->purgeAll();

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
        $purgeCacheService = new ClassProxy('Mouf\\Utils\\Cache\\Psr\\Service\\PurgeCacheService');
        $purgeCacheService->purgeAll();
    }
}
