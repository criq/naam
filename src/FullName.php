<?php

namespace Naam;

class FullName extends \ArrayObject
{
	public static function createFromString(string $value)
	{
		$token = new \Naam\Tokens\Raw($value);
		// var_dump($token);
		var_dump($token->getTokens());
	}
}
