<?php declare (strict_types = 1);

namespace App\Entity;

class Product implements \Serializable
{

	/** @var int */
	public $id;

	/** @var string */
	public $name;

	/** @var string */
	public $description;

	public function __construct(int $id, string $name, string $description)
	{
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function serialize()
	{
		return \json_encode([
			$this->id,
			$this->name,
			$this->description,
		]);
	}

	/**
	 * @param mixed $serialized
	 */
	public function unserialize($serialized): void
	{
		list($this->id, $this->name, $this->description) = \json_decode($serialized, true);
	}

}
