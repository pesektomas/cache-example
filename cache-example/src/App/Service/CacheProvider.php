<?php declare(strict_types = 1);

namespace App\Service;

use Consistence\Enum\Enum;

class CacheProvider extends Enum
{

	public const CACHE_PROVIDER_SYMFONY = 'symfony';

	public const CACHE_PROVIDER_APP = 'app';

}
