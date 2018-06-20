Purge cache UI for Mouf
=======================

When you include this library in your [Mouf](http://mouf-php.com) project, an additional button appears in the Mouf navigation bar.

By clicking this button, you can purge automatically all PSR-6, PSR-16, Doctrine and Mouf cache instances that are declared in Mouf.

Also, a "cache" menu item is added providing a UI letting UI selectively purge some cache pools.

Furthermore, this package provides an interface: `Mouf\Utils\Cache\Purge\PurgeableInterface`.
If you implement this interface on your Mouf instances, the `purge` method will be automatically
called when you click the "Purge cache" button in Mouf UI.