<?php

namespace Naam;

class Declension
{
	protected $singular;
	protected $plural;

	public function __construct(DeclensionNumber $singular, DeclensionNumber $plural)
	{
		$this->setSingular($singular);
		$this->setPlural($plural);
	}

	public static function createFromHiArray(array $hiArray): Declension
	{
		return new static(
			DeclensionNumber::createFromHiArray(array_slice($hiArray, 0, 7)),
			DeclensionNumber::createFromHiArray(array_slice($hiArray, 7, 7)),
		);
	}

	public function setSingular(DeclensionNumber $declensionNumber): Declension
	{
		$this->singular = $declensionNumber;

		return $this;
	}

	public function getSingular(): DeclensionNumber
	{
		return $this->singular;
	}

	public function setPlural(DeclensionNumber $declensionNumber): Declension
	{
		$this->plural = $declensionNumber;

		return $this;
	}

	public function getPlural(): DeclensionNumber
	{
		return $this->plural;
	}
}
