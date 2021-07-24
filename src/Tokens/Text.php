<?php

namespace Naam\Tokens;

class Text extends \Naam\Token
{
	public static function createFromRaw(string $value)
	{
		$titles = [
			'Bc\.?',
			'DiS\.?',
			'doc\.?',
			'Ing\.?',
			'JUDr\.?',
			'MBA\.?',
			'Mgr\.?',
			'MVDr\.?',
			'PhDr\.?',
			'pplk\.?',
			'prof\.?',
			'RNDr\.?',
		];

		$titlesRegexp = implode('|', $titles);

		if (preg_match("/^($titlesRegexp)$/ui", $value, $match)) {
			return new Title($value);
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
