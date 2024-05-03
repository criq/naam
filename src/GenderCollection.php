<?php

namespace Naam;

class GenderCollection extends \ArrayObject
{
	public static function createDefault(): GenderCollection
	{
		return new static([
			new \Naam\Genders\MaleGender,
			new \Naam\Genders\FemaleGender,
		]);
	}

	public function filterByHiGender(?string $hiGender): GenderCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (Gender $gender) use ($hiGender) {
			return $gender->getHiGender() == $hiGender;
		})));
	}

	public function getFirst(): ?Gender
	{
		return array_values($this->getArrayCopy())[0] ?? null;
	}

	public function getPrevalent(): ?Gender
	{
		$genderCounts = GenderCountCollection::createFromGenders($this)->filterByMaxCount();
		if (count($genderCounts) == 1) {
			return $genderCounts->getFirst()->getGender();
		}

		return null;
	}
}
