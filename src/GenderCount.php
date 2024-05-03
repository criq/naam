<?php

namespace Naam;

class GenderCount
{
	protected $count;
	protected $gender;

	public function __construct(Gender $gender, int $count = 0)
	{
		$this->setGender($gender);
		$this->setCount($count);
	}

	public function setGender(Gender $gender): GenderCount
	{
		$this->gender = $gender;

		return $this;
	}

	public function getGender(): Gender
	{
		return $this->gender;
	}

	public function setCount(int $count = 0): GenderCount
	{
		$this->count = $count;

		return $this;
	}

	public function getCount(): int
	{
		return $this->count;
	}

	public function increment(?int $value = 1): GenderCount
	{
		$this->setCount($this->getCount() + $value);

		return $this;
	}
}
