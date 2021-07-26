<?php

namespace Naam;

use Katu\Types\TClass;

class FullName extends Tokens
{
	public function getCompleteName() : string
	{
		return implode(' ', $this->getArrayCopy());
	}

	public function getName() : string
	{
		return implode(' ', array_merge($this->getFirstNames(), $this->getLastNames()));
	}

	public function getFirstNames() : array
	{
		return array_map(function ($i) {
			return new Names\FirstName($i->getValue());
		}, array_slice($this->filterByClass(new TClass("Naam\Tokens\Text"))->getArrayCopy(), 0, 1));
	}

	public function getLastNames() : array
	{
		return array_map(function ($i) {
			return new Names\LastName($i->getValue());
		}, array_slice($this->filterByClass(new TClass("Naam\Tokens\Text"))->getArrayCopy(), 1));
	}

	public function getHiGenders() : array
	{
		$genders = [];
		foreach (array_merge($this->getFirstNames(), $this->getLastNames()) as $name) {
			foreach ($name->getHiGenders() as $gender) {
				$genders[] = $gender;
			}
		}

		return $genders;
	}

	public function getPrevalentGender() : ?Gender
	{
		return Name::getPrevalentGenderFromGenders($this->getHiGenders());
	}

	public function getResponseArray() : array
	{
		return [
			'gender' => $this->getPrevalentGender()->getHiValue(),
			'completeName' => $this->getCompleteName(),
			'name' => $this->getName(),
			'firstNames' => array_map(function ($i) {
				return $i->getResponseArray();
			}, $this->getFirstNames()),
			'lastNames' => array_map(function ($i) {
				return $i->getResponseArray();
			}, $this->getLastNames()),
		];
	}
}
