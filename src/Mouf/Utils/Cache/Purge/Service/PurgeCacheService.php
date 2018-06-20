<?php

namespace Mouf\Utils\Cache\Purge\Service;

use Doctrine\Common\Cache\ClearableCache;
use Mouf\MoufManager;
use Mouf\Utils\Cache\Purge\PurgeableInterface;
use Mouf\Utils\CompositeException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Mouf\Utils\Cache\CacheInterface as MoufCacheInterface;

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

        $compositeException = new CompositeException();

        // PSR-6
        if (\interface_exists(CacheItemPoolInterface::class)) {
            $instances = $moufManager->findInstances(CacheItemPoolInterface::class);

            foreach ($instances as $instanceName) {
                try {
                    $cacheService = $moufManager->getInstance($instanceName);
                    /* @var $cacheService CacheItemPoolInterface */

                    $cacheService->clear();
                } catch (\Exception $e) {
                    $compositeException->add($e);
                }
            }
        }

        // Custom interface
        $instances = $moufManager->findInstances(PurgeableInterface::class);

        foreach ($instances as $instanceName) {
            try {
                $cacheService = $moufManager->getInstance($instanceName);
                /* @var $cacheService PurgeableInterface */

                $cacheService->purge();
            } catch (\Exception $e) {
                $compositeException->add($e);
            }
        }

        // PSR-16 interface
        if (\interface_exists(CacheInterface::class)) {
            $instances = $moufManager->findInstances(CacheInterface::class);

            foreach ($instances as $instanceName) {
                try {
                    $cacheService = $moufManager->getInstance($instanceName);
                    /* @var $cacheService CacheInterface */

                    $cacheService->clear();
                } catch (\Exception $e) {
                    $compositeException->add($e);
                }
            }
        }

        // Doctrine interface
        if (\interface_exists(ClearableCache::class)) {
            $instances = $moufManager->findInstances(ClearableCache::class);

            foreach ($instances as $instanceName) {
                try {
                    $cacheService = $moufManager->getInstance($instanceName);
                    /* @var $cacheService ClearableCache */

                    $cacheService->deleteAll();
                } catch (\Exception $e) {
                    $compositeException->add($e);
                }
            }
        }

        // Mouf interface
        if (\interface_exists(MoufCacheInterface::class)) {
            $instances = $moufManager->findInstances(MoufCacheInterface::class);

            foreach ($instances as $instanceName) {
                try {
                    $cacheService = $moufManager->getInstance($instanceName);
                    /* @var $cacheService MoufCacheInterface */

                    $cacheService->purgeAll();
                } catch (\Exception $e) {
                    $compositeException->add($e);
                }
            }
        }


        if (!$compositeException->isEmpty()) {
            throw $compositeException;
        }
    }
}
