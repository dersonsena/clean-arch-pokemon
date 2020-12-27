<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use DateTimeInterface;
use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Entity
     */
    public function setId(int $id): Entity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param array $data
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (null === $value) {
                unset($data[$key]);
            }
        }

        foreach ($data as $attribute => $value) {
            $setter = 'set' . str_replace('_', '', ucwords($attribute, '_'));

            if (!method_exists($this, $setter)) {
                continue;
            }

            $this->$setter($value);
        }
    }

    /**
     * Verify if id property is filled
     * @return bool
     */
    public function hasId(): bool
    {
        if (empty($this->getId())) {
            return false;
        }

        return true;
    }

    /**
     * Output an array based on entity properties
     * @param bool $toSnakeCase
     * @return array
     */
    public function toArray(bool $toSnakeCase = false): array
    {
        $props = [];
        $propertyList = get_object_vars($this);

        foreach ($propertyList as $prop => $value) {
            if ($value instanceof DateTimeInterface) {
                $propertyList[$prop] = $value->format(DATE_ATOM);
            }
        }

        $propertyList = json_decode(json_encode($propertyList), true);

        foreach ($propertyList as $name => $value) {
            if ($toSnakeCase) {
                $name = mb_strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
            }

            $props[$name] = $value;
        }

        return $props;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}