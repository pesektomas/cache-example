<?php declare( strict_types = 1);

namespace App\Controller;

use App\Drivers\FakeDataSource;
use App\Entity\Product;
use App\Service\Cache;
use App\Service\CacheKeys;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

	/**
	 * indexAction
	 *
	 * @Route("/product/{productId}")
	 *
	 * @param int $productId
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function productAction(int $productId): Response
	{
		/** @var \App\Service\Cache $cache */
		$cache = $this->container->get('cache');

		$productData = $this->getProduct($cache, $productId);
		$this->incrementCounter($cache, $productId);

		return new JsonResponse($productData);
	}

	/**
	 * counterAction
	 *
	 * @Route("/counter")
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function counterAction(): Response
	{
		/** @var \App\Service\Cache $cache */
		$cache = $this->container->get('cache');
		$counterJson = $cache->getCache()->get(CacheKeys::CACHE_COUNTER);

		if ($counterJson === null) {
			$counterJson = '';
		}

		return new JsonResponse(\json_decode($counterJson, true));
	}

	private function incrementCounter(Cache $cache, int $productId): void
	{
		$counterJson = $cache->getCache()->get(CacheKeys::CACHE_COUNTER);

		if ($counterJson === null) {
			$counter = [
				$productId => 1,
			];
		} else {
			$counter = \json_decode($counterJson, true);

			if (\array_key_exists($productId, $counter)) {
				$counter[$productId] = $counter[$productId] + 1;
			} else {
				$counter[$productId] = 1;
			}
		}

		$cache->getCache()->set(CacheKeys::CACHE_COUNTER, \json_encode($counter));
	}

	/**
	 * @param \App\Service\Cache $cache
	 * @param int $productId
	 *
	 * @return mixed[]
	 */
	private function getProduct(Cache $cache, int $productId): array
	{
		$method = 'cache';
		$product = $cache->getCache()->get(CacheKeys::CACHE_PRODUCT . $productId);

		if ($product === null) {

			/** @var \App\Drivers\FakeDataSource $fakeDataSource */
			$fakeDataSource = $this->container->get('fakeDataSource');

			if ($this->container->getParameter('preferDS') === FakeDataSource::DS_MYSQL) {
				$product = $fakeDataSource->findProduct($productId);
				$method = 'MySQL';
			} else {
				$product = $fakeDataSource->findById($productId);
				$method = 'Elastic';
			}

			$cache->getCache()->set(CacheKeys::CACHE_PRODUCT . $productId, $product);
		}

		return [
			'product' => $product,
			'method' => $method,
		];
	}

}
