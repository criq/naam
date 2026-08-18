<?php

namespace Naam;

use Katu\Tools\Options\OptionCollection;
use Katu\Tools\Rest\RestResponse;
use Katu\Tools\Rest\RestResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Compatibility wrapper for naam 4.x FullName used by IS Settlement.
 */
class FullName implements RestResponseInterface
{
	protected $name;

	public function __construct(?string $name = null)
	{
		$this->name = trim((string)$name);
	}

	public static function createFromString(?string $value = null): FullName
	{
		return new static($value);
	}

	public function __toString(): string
	{
		return $this->name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getRestResponse(?ServerRequestInterface $request = null, ?OptionCollection $options = null): RestResponse
	{
		return new RestResponse([
			"name" => $this->getName(),
		]);
	}
}
