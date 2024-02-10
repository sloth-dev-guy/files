<?php

namespace SlothDevGuy\Files\Models\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Trait WithUuid
 * @package SlothDevGuy\Files\Models\Traits
 *
 * @property UuidInterface uuid
 */
trait WithUuid
{
    public static function bootWithUUid(): void
    {
        static::creating(function ($model){
            /** @var WithUuid $model */

            foreach ($model->uuidColumns() as $column){
                $model->{$column} = $model->buildUuid()->toString();
            }
        });
    }

    /**
     * @return string
     */
    public function uuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * The names of the columns that should be used for the UUID.
     *
     * @return array
     */
    public function uuidColumns(): array
    {
        return [$this->uuidColumn()];
    }

    /**
     * Builds a new UUID (Universally Unique Identifier) using version 4.
     *
     * @return UuidInterface The generated UUID.
     */
    public function buildUuid(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
