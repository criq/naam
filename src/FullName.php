<?php

namespace Naam;

class FullName extends Tokens
{
	public static function createFromString(string $value)
	{
		return new static((new \Naam\Tokens\Raw($value))->getTokens());
	}
}
