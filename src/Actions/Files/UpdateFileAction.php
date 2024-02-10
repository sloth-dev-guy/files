<?php

namespace SlothDevGuy\Files\Actions\Files;

use Ramsey\Uuid\Uuid;
use SlothDevGuy\Files\Models\File;

class UpdateFileAction
{
    /**
     * @param int|string $id
     * @return File
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findFile(int|string $id): File
    {
        $builder = File::query();

        Uuid::isValid($id)? $builder->where('uuid', $id) : $builder->where('id', $id);

        return $builder->firstOrFail();
    }
}
