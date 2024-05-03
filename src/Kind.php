<?php

namespace Naam;

abstract class Kind
{
	abstract public function getHiType(): string;

	public static function createFromHiType(?string $type): ?Kind
	{
		return KindCollection::createDefault()->filterByHiType($type)->getFirst();
	}
}
