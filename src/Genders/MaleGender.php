<?php

namespace Naam\Genders;

use Katu\Tools\Strings\Code;
use Naam\Gender;

class MaleGender extends Gender
{
	public function getCode(): Code
	{
		return new Code("MALE");
	}

	public function getHiGender(): string
	{
		return "male";
	}
}
