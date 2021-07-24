<?php

namespace Naam\Tokens;

class Text extends \Naam\Token
{
	public static function createFromRaw(string $value)
	{
		$prefixes = [
			'Bc\.?',
			'doc\.?',
			'Ing\.?',
			'Ing\.?[\s_]*arch\.?',
			'JUDr\.?',
			'Mgr\.?',
			'MVDr\.?',
			'PhDr\.?',
			'pplk\.?',
			'prof\.?',
			'RNDr\.?',
		];

		$prefixesRegexp = implode('|', $prefixes);

		if (preg_match("/^($prefixesRegexp)$/ui", $value, $match)) {
			return new Prefix($value);
		}

		$suffixes = [
			'DiS\.?',
			'MBA\.?',
			'Ph\.?[\s_]*D\.?',
		];

		$suffixesRegexp = implode('|', $suffixes);

		if (preg_match("/^($suffixesRegexp)$/ui", $value, $match)) {
			return new Suffix($value);
		}

		$generationals = [
			'jr\.?',
			'ml\.?',
			'st\.?',
			'st\.?',
		];

		$generationalsRegexp = implode('|', $generationals);

		if (preg_match("/^($generationalsRegexp)$/ui", $value, $match)) {
			return new Generational($value);
		}

		return new static($value);
	}
}