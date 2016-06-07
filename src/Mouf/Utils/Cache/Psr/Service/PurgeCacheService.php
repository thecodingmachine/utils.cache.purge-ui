<?php

namespace Mouf\Utils\Cache\Psr\Service;

use Mouf\MoufManager;
use Mouf\Utils\CompositeException;
use Psr\Cache\CacheItemPoolInterface;

/**
 * This service can purge the cache of ALL cache instances (implementing CacheInterface) declared in Mouf.
 */
class PurgeCacheService
{
    /**
     * Purges the cache of ALL cache instances declared in Mouf.
     */
    public static function purgeAll()
    {
        $moufManager = MoufManager::getMoufManager();
        $instances = $moufManager->findInstances('Psr\\Cache\\CacheItemPoolInterface');

        $compositeException = new CompositeException();

        foreach ($instances as $instanceName) {
            try {
                $cacheService = $moufManager->getInstance($instanceName);
                /* @var $cacheService CacheItemPoolInterface */

                $cacheService->clear();
            } catch (\Exception $e) {
                $compositeException->add($e);
            }
        }

        if (!$compositeException->isEmpty()) {
            throw $compositeException;
        }
    }
}
