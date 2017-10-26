<?php declare (strict_types = 1);

namespace App;

use App\Exception\CacheProviderNotFoundException;
use App\Exception\ClassNotFoundException;
use App\Service\Cache;
use App\Service\CacheProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\AbstractCache;

class CacheTest extends TestCase
{

	public function testSymfonyCache(): void
	{
		$symfonyCache = new Cache('FilesystemCache', CacheProvider::CACHE_PROVIDER_SYMFONY);
		$this->assertInstanceOf(AbstractCache::class, $symfonyCache->getCache());
	}

	public function testBadSymfonyCache(): void
	{
		$cache = null;
		try {
			$symfonyCache = new Cache('FilesystemC', CacheProvider::CACHE_PROVIDER_SYMFONY);
			$cache = $symfonyCache->getCache();
			$this->fail('Expected ClassNotFoundException');
		} catch (ClassNotFoundException $ex) {
			$this->assertSame(null, $cache);
		}
	}

	public function testProviderCache(): void
	{
		$cache = null;
		try {
			$cache = new Cache('FilesystemCache', 'foo');
			$this->fail('Expected CacheProviderNotFoundException');
		} catch (CacheProviderNotFoundException $ex) {
			$this->assertSame(null, $cache);
		}
	}

}
