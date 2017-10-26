<?php declare (strict_types = 1);

namespace App\Drivers;

use App\Entity\Product;

interface IMySQLDriver
{

	public function findProduct(int $id): Product;

}
