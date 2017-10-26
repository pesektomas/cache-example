<?php declare (strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductControllerTest extends WebTestCase
{

	/**
	 * @var \Symfony\Bundle\FrameworkBundle\Client|null
	 */
	protected $client = null;

	public function setUp()
	{
		$this->client = static::createClient();
	}

	public function testProductAction(): void
	{
		if ($this->client === null) {
			$this->fail('Client is null');
			return;
		}

		$testId = 5;

		$this->client->request('GET', \sprintf('/product/%d', $testId));
		$response = $this->client->getResponse();

		$this->assertInstanceOf(JsonResponse::class, $response);

		$productObj = \json_decode($response->getContent());
		$this->assertSame($testId, $productObj->product->id);
	}

	public function testCounterAction(): void
	{
		if ($this->client === null) {
			$this->fail('Client is null');
			return;
		}

		$this->client->request('GET', \sprintf('/counter'));
		$response = $this->client->getResponse();

		$this->assertInstanceOf(JsonResponse::class, $response);
	}

	public function testProductFailAction(): void
	{
		if ($this->client === null) {
			$this->fail('Client is null');
			return;
		}

		$testId = 'test';
		$response = null;

		try {
			$this->client->request('GET', \sprintf('/product/%s', $testId));
			$response = $this->client->getResponse();

			$this->fail('Expect TypeError exception');
		} catch (\Throwable $t) {
			$this->assertSame(null, $response);
		}
	}

}
