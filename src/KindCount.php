<?php

namespace Naam;

class KindCount
{
	protected $count;
	protected $kind;

	public function __construct(Kind $kind, int $count = 0)
	{
		$this->setKind($kind);
		$this->setCount($count);
	}

	public function setKind(Kind $kind): KindCount
	{
		$this->kind = $kind;

		return $this;
	}

	public function getKind(): Kind
	{
		return $this->kind;
	}

	public function setCount(int $count = 0): KindCount
	{
		$this->count = $count;

		return $this;
	}

	public function getCount(): int
	{
		return $this->count;
	}

	public function increment(?int $value = 1): KindCount
	{
		$this->setCount($this->getCount() + $value);

		return $this;
	}
}
