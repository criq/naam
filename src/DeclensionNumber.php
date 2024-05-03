<?php

namespace Naam;

class DeclensionNumber
{
	protected $nominative;
	protected $genitive;
	protected $dative;
	protected $accusative;
	protected $vocative;
	protected $locative;
	protected $instrumental;

	public function __construct(
		string $nominative,
		string $genitive,
		string $dative,
		string $accusative,
		string $vocative,
		string $locative,
		string $instrumental
	)
	{
		$this->setNominative($nominative);
		$this->setGenitive($genitive);
		$this->setDative($dative);
		$this->setAccusative($accusative);
		$this->setVocative($vocative);
		$this->setLocative($locative);
		$this->setInstrumental($instrumental);
	}

	public static function createFromHiArray(array $hiArray): DeclensionNumber
	{
		return new static(...$hiArray);
	}

	public function setNominative(string $nominative): DeclensionNumber
	{
		$this->nominative = $nominative;

		return $this;
	}

	public function getNominative(): string
	{
		return $this->nominative;
	}

	public function setGenitive(string $genitive): DeclensionNumber
	{
		$this->genitive = $genitive;

		return $this;
	}

	public function getGenitive(): string
	{
		return $this->genitive;
	}

	public function setDative(string $dative): DeclensionNumber
	{
		$this->dative = $dative;

		return $this;
	}

	public function getDative(): string
	{
		return $this->dative;
	}

	public function setAccusative(string $accusative): DeclensionNumber
	{
		$this->accusative = $accusative;

		return $this;
	}

	public function getAccusative(): string
	{
		return $this->accusative;
	}

	public function setVocative(string $vocative): DeclensionNumber
	{
		$this->vocative = $vocative;

		return $this;
	}

	public function getVocative(): string
	{
		return $this->vocative;
	}

	public function setLocative(string $locative): DeclensionNumber
	{
		$this->locative = $locative;

		return $this;
	}

	public function getLocative(): string
	{
		return $this->locative;
	}

	public function setInstrumental(string $instrumental): DeclensionNumber
	{
		$this->instrumental = $instrumental;

		return $this;
	}

	public function getInstrumental(): string
	{
		return $this->instrumental;
	}
}
