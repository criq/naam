<?php

namespace Naam;

use Naam\Hi\Request;
use Naam\Hi\Response;
use Naam\Hi\ResultCollection;

use function PHPUnit\Framework\returnValue;

class Name
{
	protected $gender;
	protected $index;
	protected $kind;
	protected $name;

	public function __construct(int $index, string $name, ?Kind $kind = null, ?Gender $gender = null)
	{
		$this->setGender($gender);
		$this->setIndex($index);
		$this->setKind($kind);
		$this->setName((string)(new \Katu\Types\TString((string)$name))->getWithNormalizedSpaces()->getTrimmed());
	}

	public function __toString(): string
	{
		return (string)$this->getName();
	}

	public function setIndex(int $index): Name
	{
		$this->index = $index;

		return $this;
	}

	public function setName(string $name): Name
	{
		$this->name = $name;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setKind(?Kind $kind): Name
	{
		$this->kind = $kind;

		return $this;
	}

	public function getKind(): ?Kind
	{
		return $this->kind;
	}

	public function setGender(?Gender $gender): Name
	{
		$this->gender = $gender;

		return $this;
	}

	public function getGender(): ?Gender
	{
		return $this->gender;
	}

	public function getHiType(): ?string
	{
		return $this->getKind() ? $this->getKind()->getHiType() : null;
	}

	public function getHiGender(): ?string
	{
		return $this->getGender() ? $this->getGender()->getHiGender() : null;
	}

	public function getHiResponse(): Response
	{
		return (new Request($this->getName(), $this->getHiType(), $this->getHiGender()))->getResponse();
	}

	public function getHiResults(): ResultCollection
	{
		return $this->getHiResponse()->getResults()->sortByNominativeMatch($this->getName());
	}

	public function getDeclension(): ?Declension
	{
		return $this->getHiResponse()->getDeclension();
	}
}
