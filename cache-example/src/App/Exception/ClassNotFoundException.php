<?php declare (strict_types = 1);

namespace App\Exception;

use Exception;

class ClassNotFoundException extends Exception
{

	/** @var string */
	private $className;

	public function __construct(string $className)
	{
		$this->className = $className;
		parent::__construct(\sprintf('Class %s was not found', $this->className));
	}

	public function getClassName(): string
	{
		return $this->className;
	}

}
