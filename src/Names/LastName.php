<?php

namespace Naam\Names;

use Naam\Gender;
use Naam\Hi\Request;
use Naam\Kinds\LastNameKind;

/**
 * Compatibility wrapper for naam 4.x API used by IS.
 */
class LastName
{
	protected $gender;
	protected $name;

	public function __construct(?string $name = null, ?Gender $gender = null)
	{
		$this->name = trim((string)$name);
		$this->gender = $gender;
	}

	public function __toString(): string
	{
		return $this->name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getGender(): ?Gender
	{
		return $this->gender;
	}

	public function getVocative(): ?string
	{
		if (!mb_strlen($this->name)) {
			return null;
		}

		try {
			$type = (new LastNameKind)->getHiType();
			$hiGender = $this->gender ? $this->gender->getHiGender() : null;
			$results = (new Request($this->name, $type, $hiGender))->getResponse()->getResults();
			$first = $results->getArrayCopy()[0] ?? null;

			return $first ? $first->getVocative() : null;
		} catch (\Throwable $e) {
			return null;
		}
	}
}
