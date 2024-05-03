<?php

namespace Naam;

class GenderCountCollection extends \ArrayObject
{
	public static function createFromGenders(GenderCollection $genders)
	{
		$genderCounts = new static;
		array_map(function (Gender $gender) use (&$genderCounts) {
			$genderCounts->getOrCreateByGender($gender)->increment();
		}, $genders->getArrayCopy());

		return $genderCounts;
	}

	public function filterByGender(Gender $gender): GenderCountCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (GenderCount $genderCount) use ($gender) {
			return $genderCount->getGender() == $gender;
		})));
	}

	public function filterByMaxCount(): GenderCountCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (GenderCount $genderCount) {
			return $genderCount->getCount() == $this->getMaxCount();
		})));
	}

	public function getOrCreateByGender(Gender $gender): GenderCount
	{
		$genderCount = $this->filterByGender($gender)->getFirst();
		if (!$genderCount) {
			$genderCount = new GenderCount($gender);
			$this[] = $genderCount;
		}

		return $genderCount;
	}

	public function getFirst(): ?GenderCount
	{
		return array_values($this->getArrayCopy())[0] ?? null;
	}

	public function getMaxCount(): ?int
	{
		return max(array_map(function (GenderCount $genderCount) {
			return $genderCount->getCount();
		}, $this->getArrayCopy()));
	}
}
