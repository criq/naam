<?php

namespace Naam;

class Token
{
	protected $value;

	public function __construct(string $value)
	{
		$this->value = $value;
	}

	public function __toString() : string
	{
		return $this->getValue();
	}

	public function getValue() : string
	{
		return trim($this->value);
	}

	public function getTokens() : Tokens
	{
		return new Tokens([
			$this,
		]);
	}
}
