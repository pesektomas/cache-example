<?php declare (strict_types = 1);

namespace App\Exception;

use Exception;

class CacheProviderNotFoundException extends Exception
{

	/** @var string */
	private $cacheProvider;

	public function __construct(string $cacheProvider)
	{
		$this->cacheProvider = $cacheProvider;
		parent::__construct(\sprintf('Cache provider %s was not found', $this->cacheProvider));
	}

	public function getCacheProvider(): string
	{
		return $this->cacheProvider;
	}

}
