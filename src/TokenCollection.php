<?php

namespace Naam;

use Katu\Types\TClass;

class TokenCollection extends \ArrayObject
{
	public function __toString(): string
	{
		return implode(" ", array_map(function (Token $token) {
			return $token->getValue();
		}, $this->getArrayCopy()));
	}

	public static function createFromString(string $value): TokenCollection
	{
		$value = preg_replace("/,/", "", $value);
		$value = preg_replace("/\./", ". ", $value);
		$value = preg_replace("/&nbsp;/", " ", $value);
		$value = preg_replace("/\s+/", " ", $value);
		$value = trim($value);

		// Preserve multi-word prefixes, suffixes.
		$value = preg_replace("/Ing\.?\s*arch\.?/ui", "Ing._arch.", $value);
		$value = preg_replace("/Ph\.?\s*D\.?/ui", "PhD.", $value);

		$index = 0;

		return new static(array_values(array_filter(array_map(function (string $part) use (&$index) {
			return Token::createFromString($index++, $part);
		}, preg_split("/\s/", $value)), "trim")));
	}

	public function filterByClass(TClass $class): TokenCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function ($token) use ($class) {
			return (new TClass($token))->getName() == $class->getName();
		})));
	}

	public function getGendersFromHi(): GenderCollection
	{
		return new GenderCollection(array_merge(...array_filter(array_map(function (Token $token) {
			return $token->getGendersFromHi()->getArrayCopy();
		}, $this->getArrayCopy()))));
	}

	public function getGenderFromHi(): ?Gender
	{
		return $this->getGendersFromHi()->getPrevalent();
	}

	public function getNames(): NameCollection
	{
		return new NameCollection(array_values(array_filter(array_map(function (Token $token) {
			return $token->setGender($this->getGenderFromHi())->getName();
		}, $this->getArrayCopy()))));
	}
}
