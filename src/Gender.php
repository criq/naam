<?php

namespace Naam;

use Katu\Tools\Strings\Code;
use Katu\Types\TClass;

abstract class Gender
{
	abstract public function getCode(): Code;
	abstract public function getHiGender(): string;

	public function __toString(): string
	{
		return (string)(new TClass($this))->getPortableName();
	}

	public static function createFromHiGender(?string $hiGender): ?Gender
	{
		return GenderCollection::createDefault()->filterByHiGender($hiGender)->getFirst();
	}
}
