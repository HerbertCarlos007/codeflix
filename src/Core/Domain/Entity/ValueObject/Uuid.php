<?php

namespace Core\Domain\Entity\ValueObject;

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamesyUuid;

class Uuid
{
    public function __construct(
        protected string $value
    )
    {
        $this->ensureIsValid($this->value);
    }

    public static function random(): self
    {
        $uuid = RamesyUuid::uuid4()->toString();
        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValid(string $id)
    {
        if (!RamesyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('Invalid UUID: %s', $id));
        }
    }
}