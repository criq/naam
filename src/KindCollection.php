<?php

namespace Naam;

class KindCollection extends \ArrayObject
{
	public static function createDefault(): KindCollection
	{
		return new static([
			new \Naam\Kinds\FirstNameKind,
			new \Naam\Kinds\LastNameKind,
		]);
	}

	public function filterByHiType(?string $hiType): KindCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (Kind $kind) use ($hiType) {
			return $kind->getHiType() == $hiType;
		})));
	}

	public function getFirst(): ?Kind
	{
		return array_values($this->getArrayCopy())[0] ?? null;
	}

	public function getPrevalent(): ?Kind
	{
		$kindCounts = KindCountCollection::createFromKinds($this)->filterByMaxCount();
		if (count($kindCounts) == 1) {
			return $kindCounts->getFirst()->getKind();
		}

		return null;
	}
}
