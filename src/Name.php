<?php

namespace Naam;

use Katu\Types\TClass;

abstract class Name
{
	const HI_TYPE = null;

	protected $name;
	protected $gender;

	public function __construct(string $name, ?Gender $gender = null)
	{
		$this->name = (string)(new \Katu\Types\TString((string)$name))->normalizeSpaces()->trim();
		$this->gender = $gender;
	}

	public function __toString() : string
	{
		return (string)$this->getName();
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getGender() : ?Gender
	{
		return $this->gender;
	}

	public function getHiType() : string
	{
		return (string)static::HI_TYPE;
	}

	public function getHiParams() : array
	{
		$params = [
			'type' => $this->getHiType(),
			'name' => $this->getName(),
		];

		if ($this->getGender()) {
			$params['gender'] = $this->getGender()->getHiValue();
		}

		return $params;
	}

	public function getHiResponse($timeout = '1 month') : ?array
	{
		$url = \Katu\Types\TUrl::make('http://hi.ondraplsek.cz', $this->getHiParams());
		$res = \Katu\Cache\Url::get($url, $timeout);

		if ($res->success ?? null) {
			return $res->results;
		}

		return null;
	}

	public function getHiGenders() : array
	{
		$genders = array_map(function ($item) {
			return Gender::createFromHiValue($item->gender);
		}, $this->getHiResponse());

		return $genders;
	}

	public static function getPrevalentGenderFromGenders(array $genders) : ?Gender
	{
		try {
			$genders = array_map(function ($i) {
				return (string)$i;
			}, $genders);

			$genderCounts = array_count_values($genders);
			asort($genderCounts, \SORT_NATURAL);
			$genderCounts = array_reverse($genderCounts);

			if (!array_sum($genderCounts)) {
				return null;
			}

			$genderCountValues = array_values($genderCounts);
			if (count($genderCountValues) == 2 && $genderCountValues[0] == $genderCountValues[1]) {
				return null;
			}

			$class = TClass::createFromStorableName(array_keys($genderCounts)[0]);
			$className = $class->getName();

			return new $className;
		} catch (\Throwable $e) {
			return null;
		}
	}

	public function getPrevalentGender() : ?Gender
	{
		return static::getPrevalentGenderFromGenders($this->getHiGenders());
	}

	public function getHiResultsByGender(Gender $gender) : array
	{
		return array_values(array_filter($this->getHiResponse(), function ($i) use ($gender) {
			return $i->gender == $gender->getHiValue();
		}));
	}

	public function getVocative() : ?string
	{
		try {
			$res = $this->getHiResponse();
			if (!$res) {
				return null;
			}

			if ($this->getGender()) {
				$genderResults = $this->getHiResultsByGender($this->getGender());
			} else {
				$genderResults = $this->getHiResultsByGender($this->getPrevalentGender());
			}

			return $genderResults[0]->vocativ;
		} catch (\Throwable $e) {
			return null;
		}
	}

	public function getResponseArray() : array
	{
		return [
			'nominative' => $this->getName(),
			'vocative' => $this->getVocative(),
			'gender' => $this->getPrevalentGender()->getHiValue(),
		];
	}
}
