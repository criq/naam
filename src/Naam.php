<?php

namespace Naam;

class Naam {

	public function __construct($type, $name, $gender) {
		$this->type = $type;
		$this->name = $name;
		$this->gender = $gender;
	}

	public function getVocative() {
		$res = \Katu\Utils\Cache::get(function($type, $name, $gender) {

			$curl = new \Curl\Curl;
			$res = $curl->get('http://hi.ondraplsek.cz', [
				'name' => $name,
				'type' => $type,
				'gender' => $gender,
			]);

			if (!isset($res->success) || (isset($res->success) && !$res->success)) {
				return false;
			}

			var_dump($res->results[0]); die;

		}, 86400 * 28, $hiType, $hiName, $hiGender);
	}

}
