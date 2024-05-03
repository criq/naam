<?php

namespace Naam\Hi;

use Naam\Declension;
use Naam\Gender;
use Naam\Kind;

class Response
{
	protected $payload;

	public function __construct($payload)
	{
		$this->setPayload($payload);
	}

	public function setPayload($payload): Response
	{
		$this->payload = $payload;

		return $this;
	}

	public function getPayload()
	{
		return $this->payload;
	}

	public function getIsSuccess(): bool
	{
		return $this->getPayload()->success;
	}

	public function getResults(): ResultCollection
	{
		return new ResultCollection(array_map(function (\stdClass $object) {
			return new Result($object->nominativ, $object->vocativ, Kind::createFromHiType($object->type), Gender::createFromHiGender($object->gender));
		}, $this->getPayload()->results));
	}

	public function getDeclension(): Declension
	{
		return Declension::createFromHiArray((array)$this->getPayload()->declension);
	}
}
