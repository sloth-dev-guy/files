<?php

namespace SlothDevGuy\Files\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Support\Collection;
use SlothDevGuy\Files\Models\Casts\UuidCast;
use SlothDevGuy\Files\Models\Traits\WithUuid;

/**
 * Class File
 * @package SlothDevGuy\Files\Models
 *
 * @property string disk
 * @property string path
 * @property string name
 * @property string checksum
 * @property Collection metadata
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class File extends BaseModel
{
    use WithUuid;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => UuidCast::class,
        'metadata' => AsCollection::class,
    ];
}