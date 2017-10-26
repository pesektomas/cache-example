<?php declare (strict_types = 1);

namespace App\Drivers;

use App\Entity\Product;

class FakeDataSource implements IElasticSearchDriver, IMySQLDriver
{

	public const DS_MYSQL = 'MySQL';

	public const DS_ELASTIC = 'Elastic';

	public function findById(int $id): Product
	{
		return $this->getFakeData($id);
	}

	public function findProduct(int $id): Product
	{
		return $this->getFakeData($id);
	}

	private function getFakeData(int $id): Product
	{
		return new Product(
			$id,
			\sprintf('Product %d', $id),
			\sprintf('Product description %d', $id)
		);
	}

}
