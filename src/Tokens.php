<?php

namespace Naam;

use Katu\Types\TClass;

class Tokens extends \ArrayObject
{
	public function __toString() : string
	{
		return implode(' ', $this->getArrayCopy());
	}

	public static function createFromString(string $value) : FullName
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
		$value = preg_replace('/Ph\s*\.?D\.?/ui', 'PhD.', $value);

		foreach (preg_split('/\s/', $value) as $part) {
			$tokens[] = Tokens\Text::createFromRaw($part);
		}

		$tokens = new static(array_values(array_filter($tokens, 'trim')));

		return $tokens;
	}

	public function filterByClass(TClass $class) : Tokens
	{
		return new Tokens(array_values(array_filter($this->getArrayCopy(), function ($token) use ($class) {
			return new TClass($token) == $class;
		})));
	}
}
