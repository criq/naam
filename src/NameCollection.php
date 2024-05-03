<?php

namespace Naam;

use Naam\Kinds\FirstNameKind;
use Naam\Kinds\LastNameKind;

class NameCollection extends \ArrayObject
{
	public function filterByKind(Kind $kind): NameCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (Name $name) use ($kind) {
			return $name->getKind() == $kind;
		})));
	}

	public function getFirst(): ?Name
	{
		return array_values($this->getArrayCopy())[0] ?? null;
	}

	public function getFirstNames(): NameCollection
	{
		return $this->filterByKind(new FirstNameKind);
	}

	public function getLastNames(): NameCollection
	{
		return $this->filterByKind(new LastNameKind);
	}
}
