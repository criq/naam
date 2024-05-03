<?php

namespace Naam;

use Naam\Hi\Response;
use Naam\Tokens\GenerationalToken;
use Naam\Tokens\NameToken;
use Naam\Tokens\PrefixToken;
use Naam\Tokens\SuffixToken;

abstract class Token
{
	protected $gender;
	protected $index;
	protected $kind;
	protected $value;

	public function __construct(int $index, string $value, ?Kind $kind = null, ?Gender $gender = null)
	{
		$this->setGender($gender);
		$this->setIndex($index);
		$this->setKind($kind);
		$this->setValue($value);
	}

	public function __toString(): string
	{
		return $this->getValue();
	}

	public static function createFromString(int $index, string $value): Token
	{
		$prefixesRegexp = implode("|", static::getPrefixes());;
		if (preg_match("/^($prefixesRegexp)$/ui", $value, $match)) {
			return new PrefixToken($index, $value);
		}

		$suffixesRegexp = implode("|", static::getSuffixes());
		if (preg_match("/^($suffixesRegexp)$/ui", $value, $match)) {
			return new SuffixToken($index, $value);
		}

		$generationalsRegexp = implode("|", static::getGenerationals());
		if (preg_match("/^($generationalsRegexp)$/ui", $value, $match)) {
			return new GenerationalToken($index, $value);
		}

		return new NameToken($index, $value);
	}

	public static function getPrefixes(): array
	{
		return [
			"Bc\.?",
			"doc\.?",
			"Dr\.?",
			"et",
			"Ing\.?",
			"Ing\.?[\s_]*arch\.?",
			"JUDr\.?",
			"Lic\.",
			"MgA\.?",
			"Mgr\.?",
			"MUDr\.?",
			"MVDr\.?",
			"PaedDr\.?",
			"PharmDr\.?",
			"PhD\.r\.",
			"PhDr\.?",
			"pplk\.?",
			"prof\.?",
			"RNDr\.?",
			"RSDr\.?",
			"ThMgr\.?",
		];
	}

	public static function getSuffixes(): array
	{
		return [
			"CSc\.?",
			"DiS\.?",
			"MA\.?",
			"MBA\.?",
			"Ph\.?[\s_]*D\.?",
		];
	}

	public static function getGenerationals(): array
	{
		return [
			"jr\.?",
			"ml\.?",
			"st\.?",
			"st\.?",
		];
	}

	public function setIndex(int $index): Token
	{
		$this->index = $index;

		return $this;
	}

	public function getIndex(): int
	{
		return $this->index;
	}

	public function setValue(string $value): Token
	{
		$this->value = trim($value);

		return $this;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function setKind(?Kind $kind): Token
	{
		$this->kind = $kind;

		return $this;
	}

	public function getKind(): ?Kind
	{
		return $this->kind;
	}

	public function getGendersFromHi(): GenderCollection
	{
		$hiResponse = $this->getHiResponse();
		if ($hiResponse) {
			return $hiResponse->getResults()->getGenders();
		}

		return new GenderCollection;
	}

	public function setGender(?Gender $gender): Token
	{
		$this->gender = $gender;

		return $this;
	}

	public function getGender(): ?Gender
	{
		return $this->gender;
	}

	public function getHiType(): ?string
	{
		return $this->getKind() ? $this->getKind()->getHiType() : null;
	}

	public function getHiGender(): ?string
	{
		return $this->getGender() ? $this->getGender()->getHiGender() : null;
	}

	public function getHiResponse(): ?Response
	{
		return null;
	}

	public function getName(): ?Name
	{
		return null;
	}
}