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

	/**
	 * Compatibility with naam 4.x (IS / osobniudaje).
	 * Accepts hi genders ("male"/"female") or portable codes ("MALE"/"FEMALE"/…).
	 */
	public static function createFromCode($value): ?Gender
	{
		if ($value === null || $value === "") {
			return null;
		}

		$code = strtoupper(trim((string)$value));
		if ($code === "M" || $code === "MALE" || $code === "MUZ" || $code === "MUŽ") {
			return new \Naam\Genders\MaleGender;
		}
		if ($code === "F" || $code === "FEMALE" || $code === "ZENA" || $code === "ŽENA") {
			return new \Naam\Genders\FemaleGender;
		}

		return static::createFromHiGender(strtolower((string)$value));
	}
}
