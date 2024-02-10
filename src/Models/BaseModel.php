<?php

namespace SlothDevGuy\Files\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class BaseModel
 * @package SlothDevGuy\Files\Models
 *
 * @property int id
 */
abstract class BaseModel extends Model
{
    protected $guarded = [
        'id',
        'uuid',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table ?? Str::snake(Str::singular(class_basename($this)));
    }
}
