<?php

namespace Naam;

use Katu\Tools\Rest\RestResponse;
use Katu\Tools\Rest\RestResponseInterface;
use Katu\Types\TClass;
use Psr\Http\Message\ServerRequestInterface;

class FullName extends Tokens implements RestResponseInterface
{
	public function __toString() : string
	{
		return $this->getName();
	}

	public function getAffixedName() : ?string
	{
		return trim(implode(" ", $this->getArrayCopy())) ?: null;
	}

	public function getName() : ?string
	{
		return trim(implode(" ", array_merge($this->getFirstNames(), $this->getLastNames()))) ?: null;
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

	public function getRestResponse(?ServerRequestInterface $request = null): RestResponse
	{
		try {
			$genderValue = $this->getPrevalentGender()->getHiValue();
		} catch (\Throwable $e) {
			$genderValue = null;
		}

		return new RestResponse([
			"gender" => $genderValue,
			"affixedName" => $this->getAffixedName(),
			"fullName" => $this->getName(),
			"firstNames" => array_map(function ($i) {
				return $i->getRestResponse();
			}, $this->getFirstNames()),
			"lastNames" => array_map(function ($i) {
				return $i->getRestResponse();
			}, $this->getLastNames()),
		]);
	}
}
