<?php

namespace Naam\Hi;

use Katu\Tools\Calendar\Timeout;
use Katu\Types\TIdentifier;

class Request
{
	protected $name;
	protected $type;
	protected $gender;

	public function __construct(string $name, ?string $type = null, ?string $gender = null)
	{
		$this->setName($name);
		$this->setType($type);
		$this->setGender($gender);
	}

	public function setName(string $name): Request
	{
		$this->name = $name;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setType(?string $type): Request
	{
		$this->type = $type;

		return $this;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function setGender(?string $gender): Request
	{
		$this->gender = $gender;

		return $this;
	}

	public function getGender(): ?string
	{
		return $this->gender;
	}

	public function getResponse(): Response
	{
		return (new \Katu\Cache\General(new TIdentifier(__CLASS__, __FUNCTION__), $this->getTimeout(), function ($params) {
			$url = \Katu\Types\TURL::make("http://hi.ondraplsek.cz", $params);

			$curl = new \Curl\Curl;
			$curl->setOpt(CURLOPT_FOLLOWLOCATION, true);

			return new Response($curl->get($url));
		}))
			->setArgs($this->getParams())
			->disableMemory()
			->getResult()
			;
	}

	public function getParams(): array
	{
		$params = [
			"name" => $this->getName(),
		];

		if ($this->getType()) {
			$params["type"] = $this->getType();
		}

		if ($this->getGender()) {
			$params["gender"] = $this->getGender();
		}

		return $params;
	}

	public function getTimeout(): Timeout
	{
		return new Timeout("1 month");
	}
}
