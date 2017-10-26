<?php declare( strict_types = 1);

namespace App\Service;

use App\Exception\CacheProviderNotFoundException;
use App\Exception\ClassNotFoundException;
use Nette\Neon\Exception;
use Symfony\Component\Cache\Simple\AbstractCache;

class Cache
{

	/** @var  string */
	private $cacheType;

	/** @var  \App\Service\CacheProvider */
	private $cacheProvider;

	public function __construct(string $cacheType, string $cacheProvider = CacheProvider::CACHE_PROVIDER_SYMFONY)
	{
		if (!CacheProvider::isValidValue($cacheProvider)) {
			throw new CacheProviderNotFoundException($cacheProvider);
		}

		$this->cacheType = $cacheType;
		$this->cacheProvider = CacheProvider::get($cacheProvider);
	}

	public function getCache(): AbstractCache
	{
		if (CacheProvider::get(CacheProvider::CACHE_PROVIDER_SYMFONY) === $this->cacheProvider) {
			$classObject = 'Symfony\\Component\\Cache\\Simple\\' . $this->cacheType;

			if (\class_exists($classObject)) {
				return new $classObject();
			} else {
				throw new ClassNotFoundException($classObject);
			}
		} elseif (CacheProvider::get(CacheProvider::CACHE_PROVIDER_APP) === $this->cacheProvider) {
			throw new Exception('App provider not implemented');
		}
	}

}
