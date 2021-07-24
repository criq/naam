<?php

namespace Naam\Tokens;

class Raw extends \Naam\Token
{
	public function __construct(string $value)
	{
		$this->value = $value;
		$this->value = preg_replace('/,/', '', $this->value);
		$this->value = preg_replace('/\./', '. ', $this->value);
		$this->value = preg_replace('/\s+/', ' ', $this->value);
		$this->value = trim($this->value);
	}

	public function getTokens() : \Naam\Tokens
	{
		$tokens = new \Naam\Tokens;

		/**************************************************************************
		 * Preserve multi-word prefixes, suffixes.
		 */
		$value = $this->getValue();
		$value = preg_replace('/Ing\.?\s*arch\.?/ui', 'Ing._arch.', $value);
		$value = preg_replace('/Ph. D./ui', 'PhD.', $value);

		foreach (preg_split('/\s/', $value) as $part) {
			$tokens[] = Text::createFromRaw($part);
		}

		$tokens = new \Naam\Tokens(array_values(array_filter($tokens->getArrayCopy(), 'trim')));

		return $tokens;
	}
}
