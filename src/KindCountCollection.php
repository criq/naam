<?php

namespace Naam;

class KindCountCollection extends \ArrayObject
{
	public static function createFromKinds(KindCollection $kinds)
	{
		$kindCounts = new static;
		array_map(function (Kind $kind) use (&$kindCounts) {
			$kindCounts->getOrCreateByKind($kind)->increment();
		}, $kinds->getArrayCopy());

		return $kindCounts;
	}

	public function filterByKind(Kind $kind): KindCountCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (KindCount $kindCount) use ($kind) {
			return $kindCount->getKind() == $kind;
		})));
	}

	public function filterByMaxCount(): KindCountCollection
	{
		return new static(array_values(array_filter($this->getArrayCopy(), function (KindCount $kindCount) {
			return $kindCount->getCount() == $this->getMaxCount();
		})));
	}

	public function getOrCreateByKind(Kind $kind): KindCount
	{
		$kindCount = $this->filterByKind($kind)->getFirst();
		if (!$kindCount) {
			$kindCount = new KindCount($kind);
			$this[] = $kindCount;
		}

		return $kindCount;
	}

	public function getFirst(): ?KindCount
	{
		return array_values($this->getArrayCopy())[0] ?? null;
	}

	public function getMaxCount(): ?int
	{
		return max(array_map(function (KindCount $kindCount) {
			return $kindCount->getCount();
		}, $this->getArrayCopy()));
	}
}
