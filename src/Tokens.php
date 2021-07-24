<?php

namespace Naam;

class Tokens extends \ArrayObject
{
	public static function createFromString(string $value) : Tokens
	{
		$value = preg_replace('/,/', '', $value);
		$value = preg_replace('/\./', '. ', $value);
		$value = preg_replace('/&nbsp;/', ' ', $value);
		$value = preg_replace('/\s+/', ' ', $value);
		$value = trim($value);

		/**************************************************************************
		 * Preserve multi-word prefixes, suffixes.
		 */
		$value = preg_replace('/Ing\.?\s*arch\.?/ui', 'Ing._arch.', $value);
		$value = preg_replace('/Ph. D./ui', 'PhD.', $value);

		foreach (preg_split('/\s/', $value) as $part) {
			$tokens[] = Tokens\Text::createFromRaw($part);
		}

		$tokens = new \Naam\Tokens(array_values(array_filter($tokens, 'trim')));

		return $tokens;
	}
}
