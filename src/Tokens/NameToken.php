<?php

namespace Naam\Tokens;

use Naam\Hi\Request;
use Naam\Hi\Response;
use Naam\Name;

class NameToken extends \Naam\Token
{
	public function getHiResponse(): ?Response
	{
		return (new Request($this->getValue(), $this->getHiType(), $this->getHiGender()))->getResponse();
	}

	public function getName(): ?Name
	{
		$result = $this->getHiResponse()->getResults()->sortByNominativeMatch($this->getValue())->getFirst();
		if ($result) {
			return new Name($this->getIndex(), $result->getNominative(), $result->getKind(), $result->getGender());
		}

		return null;
	}
}
