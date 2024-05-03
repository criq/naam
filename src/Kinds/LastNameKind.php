<?php

namespace Naam\Kinds;

use Naam\Kind;

class LastNameKind extends Kind
{
	public function getHiType(): string
	{
		return "surname";
	}
}
