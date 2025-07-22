<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTraits;
use Core\Domain\Exception\EntityValidationException;

class Category
{
    use MethodsMagicsTraits;

    public function __construct(
        protected string $id = '',
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
    ) {
        $this->validate();
    }

    public function validate()
    {
        if (empty($this->name)) {
            throw new EntityValidationException('Nome inválido');
        }

        if (strlen($this->name) > 255 || strlen($this->name) <= 2) {
            throw new EntityValidationException('descriçao inválido');
        }

        if ($this->description != '' && (strlen($this->description) > 255 || strlen($this->description) <= 3)) {
            throw new EntityValidationException('descriçao inválido');
        }
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function update(string $name, string $description = '')
    {
        $this->name = $name;;
        $this->description = $description;

        $this->validate();
    }
}