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

		if (preg_match('/^(.*)(Ing\.\s*arch\.|Ph\.\s*D\.)(.*)$/ui', $this->getValue(), $match)) {
			foreach (preg_split('/\s/', $match[1]) as $part) {
				foreach ((new static($part))->getTokens() as $token) {
					$tokens[] = $token;
				}
			}
			$tokens[] = new Title($match[2]);
			foreach (preg_split('/\s/', $match[3]) as $part) {
				foreach ((new static($part))->getTokens() as $token) {
					$tokens[] = $token;
				}
			}
		} else {
			$parts = preg_split('/\s/', $this->getValue());
			if (count($parts) == 1) {
				$tokens[] = Text::createFromRaw($parts[0]);
			} elseif (count($parts) > 1) {
				foreach ($parts as $part) {
					foreach ((new static($part))->getTokens() as $token) {
						$tokens[] = $token;
					}
				}
			}
		}

		$tokens = new \Naam\Tokens(array_values(array_filter($tokens->getArrayCopy(), 'trim')));

		return $tokens;
	}
}
