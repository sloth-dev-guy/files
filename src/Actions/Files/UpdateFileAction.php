<?php

namespace SlothDevGuy\Files\Actions\Files;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use SlothDevGuy\Files\Http\Requests\Files\UpdateFileRequest;
use SlothDevGuy\Files\Models\File;

class UpdateFileAction
{
    use FileAggregateRootResponse;

    public function __construct(
        protected readonly UpdateFileRequest $request
    )
    {

    }

    public function execute(): void
    {
        if(isset($this->file)){
            return;
        }

        $this->file = DB::transaction(function (){
            $file = static::findFile($this->request->route('file'));
            $file->fill($this->request->fileValues());
            $file->save();

            !empty($this->request->references()) &&
                StoreFileAction::syncReferences($file, $this->request->references());

            return $file;
        });
    }

    /**
     * @param int|string $id
     * @return File
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findFile(int|string $id, bool $withoutGlobalScopes = false): File
    {
        $builder = File::query();

        $withoutGlobalScopes && $builder->withoutGlobalScopes();

        Uuid::isValid($id)? $builder->where('uuid', $id) : $builder->where('id', $id);

        return $builder->firstOrFail();
    }
}
