<?php

namespace Naam;

class Naam
{
	public function __construct(string $type, string $name, string $gender = null)
	{
		$this->type = (string)(new \Katu\Types\TString((string)$type))->normalizeSpaces()->trim();
		$this->name = (string)(new \Katu\Types\TString((string)$name))->normalizeSpaces()->trim();
		$this->gender = (string)(new \Katu\Types\TString((string)$gender))->normalizeSpaces()->trim();
	}

	public function getRes(int $timeout = 2419200) : array
	{
		return \Katu\Cache\General::get([__CLASS__, __FUNCTION__], $timeout, function ($naam) {
			$data = [
				'type' => $naam->type,
				'name' => $naam->name,
			];

			if ($this->gender) {
				$data['gender'] = $this->gender;
			}

			$url = \Katu\Types\TUrl::make('http://hi.ondraplsek.cz', $data);
			$res = \Katu\Cache\Url::get($url);

			if (isset($res->success) && $res->success) {
				return $res->results;
			}

			return [];
		}, $this);
	}

	public function getGenders() : array
	{
		$genders = array_map(function ($item) {
			return $item->gender;
		}, $this->getRes());

		return $genders;
	}

	public static function getPrevalentGenderFromGenders($genders) : string
	{
		$genderCounts = array_count_values($genders);
		asort($genderCounts, \SORT_NATURAL);
		$genderCounts = array_reverse($genderCounts);

		if (!isset($genderCounts['male']) && !isset($genderCounts['female'])) {
			return false;
		}

		if (isset($genderCounts['male'], $genderCounts['female']) && $genderCounts['male'] == $genderCounts['female']) {
			return false;
		}

		return array_keys($genderCounts)[0];
	}

	public function getPrevalentGender() : string
	{
		return static::getPrevalentGenderFromGenders($this->getGenders());
	}

	public function getVocativesByGender($gender) : array
	{
		return array_values(array_filter($this->getRes(), function ($item) use ($gender) {
			return $item->gender == $gender;
		}));
	}

	public function getVocativesRes() : ?array
	{
		$res = $this->getRes();
		if (!$res) {
			return null;
		}

		if ($this->gender) {
			return $this->getVocativesByGender($this->gender);
		} else {
			return $this->getVocativesByGender($this->getPrevalentGender());
		}
	}

	public function getVocative() : string
	{
		$res = $this->getVocativesRes();
		if (isset($res[0]->vocativ)) {
			return $res[0]->vocativ;
		}

		return false;
	}
}
