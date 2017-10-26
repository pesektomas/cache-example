<?php declare (strict_types = 1);

namespace App\Drivers;

use App\Entity\Product;

interface IElasticSearchDriver
{

	public function findById(int $id): Product;

}
