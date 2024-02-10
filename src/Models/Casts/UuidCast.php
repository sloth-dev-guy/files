<?php

namespace SlothDevGuy\Files\Models\Casts;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Class UuidCast
 * @package SlothDevGuy\Files\Models\Casts
 *
 * This class is responsible for casting UUID values to and from the UuidInterface object.
 */
class UuidCast implements CastsAttributes
{
    /**
     * Retrieves a UuidInterface object from a given value.
     *
     * @param object $model The model object.
     * @param string $key The key to access the value.
     * @param mixed $value The value to be converted to a UuidInterface object.
     * @param array $attributes Additional attributes (if any) that may be required for the conversion process.
     *
     * @return UuidInterface|null The UuidInterface object created from the given value.
     */
    public function get($model, string $key, mixed $value, array $attributes): UuidInterface|null
    {
        return is_null($value)? $value : Uuid::fromString($value);
    }

    /**
     * Set the value of a key in the given model's attributes.
     *
     * @param Model $model The model instance.
     * @param string $key The key to set.
     * @param string|UuidInterface $value The value to set.
     * @param array $attributes The array of attributes.
     *
     * @return array The updated array of attributes with the new key-value pair.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if($value instanceof UuidInterface){
            $value = $value->toString();
        }

        return [$key => $value];
    }
}
