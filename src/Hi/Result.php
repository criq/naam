<?php

namespace Naam\Hi;

use Naam\Gender;
use Naam\Kind;

class Result
{
	protected $gender;
	protected $kind;
	protected $nominative;
	protected $vocative;

	public function __construct(string $nominative, ?string $vocative = null, ?Kind $kind = null, ?Gender $gender = null)
	{
		$this->setGender($gender);
		$this->setKind($kind);
		$this->nominative = $nominative;
		$this->vocative = $vocative;
	}

	public function setKind(?Kind $kind): Result
	{
		$this->kind = $kind;

		return $this;
	}

	public function getKind(): ?Kind
	{
		return $this->kind;
	}

	public function setGender(?Gender $gender): Result
	{
		$this->gender = $gender;

		return $this;
	}

	public function getGender(): ?Gender
	{
		return $this->gender;
	}

	public function setNominative(string $nominative): Result
	{
		$this->nominative = $nominative;

		return $this;
	}

	public function getNominative(): string
	{
		return $this->nominative;
	}

	public function setVocative(string $vocative): Result
	{
		$this->vocative = $vocative;

		return $this;
	}

	public function getVocative(): string
	{
		return $this->vocative;
	}
}
