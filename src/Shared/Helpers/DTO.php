<?php

declare(strict_types=1);

namespace App\Shared\Helpers;

abstract class DTO
{
    private function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (mb_strstr($key, '_') !== false) {
                $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            }

            if (!property_exists($this, $key)) {
                continue;
            }

            $this->{$key} = $value;
        }
    }

    /**
     * @param array $data
     * @return static
     */
    public static function build(array $data): self
    {
        return new static($data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $objProperties = get_object_vars($this);
        $props = [];

        foreach ($objProperties as $name => $value) {
            $getter = "get" . ucfirst($name);

            if (mb_strstr($name, '_') !== false) {
                $getter = "get" . str_replace('_', '', ucwords($name, '_'));
            }

            if (!method_exists($this, $getter)) {
                continue;
            }

            $props[$name] = $this->$getter();
        }

        return $props;
    }
}