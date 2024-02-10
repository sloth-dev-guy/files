<?php

namespace SlothDevGuy\Files\Models;

use SlothDevGuy\Files\Models\Casts\UuidCast;
use SlothDevGuy\Files\Models\Traits\WithUuid;

/**
 * Class EntityReference
 * @package SlothDevGuy\Files\Models
 */
class EntityReference extends BaseModel
{
    use WithUuid;

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => UuidCast::class,
    ];
}
