<?php

namespace Naam;

use Katu\Types\TClass;

abstract class Gender
{
	public function __toString()
	{
		return (string)(new TClass($this))->getPortableName();
	}

	public static function createFromCode($value) : ?Gender
	{
		try {
			$class = static::getHiMap()[$value];
			$className = $class->getName();

			return new $className;
		} catch (\Throwable $e) {
			return null;
		}
	}

	public static function createFromHiValue($value) : ?Gender
	{
		try {
			$class = static::getHiMap()[$value];
			$className = $class->getName();

			return new $className;
		} catch (\Throwable $e) {
			return null;
		}
	}

	public static function getHiMap() : array
	{
		return [
			"male" => new TClass("Naam\Genders\Male"),
			"female" => new TClass("Naam\Genders\Female"),
		];
	}

	public function getHiValue() : ?string
	{
		foreach (static::getHiMap() as $value => $class) {
			if (new TClass($this) == $class) {
				return $value;
			}
		}

		return null;
	}
}
