<?php

namespace Naam\Genders;

use Katu\Tools\Strings\Code;
use Naam\Gender;

class FemaleGender extends Gender
{
	public function getCode(): Code
	{
		return new Code("FEMALE");
	}

	public function getHiGender(): string
	{
		return "female";
	}
}
