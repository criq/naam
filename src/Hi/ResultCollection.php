<?php

namespace Naam\Hi;

use Naam\GenderCollection;
use Naam\KindCollection;

class ResultCollection extends \ArrayObject
{
	public function sortByNominativeMatch(string $nominative): ResultCollection
	{
		$array = $this->getArrayCopy();
		usort($array, function (Result $a, Result $b) use ($nominative) {
			return $a->getNominative() == $nominative ? -1 : ($b->getNominative() == $nominative ? 1 : 0);
		});

		return new static($array);
	}

	public function getFirst(): ?Result
	{
		return array_values($this->getArrayCopy())[0] ?? null;
	}

	public function getKinds(): KindCollection
	{
		return new KindCollection(array_map(function (Result $result) {
			return $result->getKind();
		}, $this->getArrayCopy()));
	}

	public function getGenders(): GenderCollection
	{
		return new GenderCollection(array_map(function (Result $result) {
			return $result->getGender();
		}, $this->getArrayCopy()));
	}
}
