<?php

namespace Naam\Kinds;

use Naam\Kind;

class FirstNameKind extends Kind
{
	public function getHiType(): string
	{
		return "name";
	}
}
