<?php

namespace SlothDevGuy\Files\Actions\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use SlothDevGuy\Files\Http\Requests\Files\StoreFileRequest;
use SlothDevGuy\Files\Models\EntityReference;
use SlothDevGuy\Files\Models\File;

class StoreFileAction
{
    use FileAggregateRootResponse;

    public function __construct(
        public readonly StoreFileRequest $request,
    )
    {

    }

    public function execute(): void
    {
        if(isset($this->file)){
            return;
        }

        $this->file = DB::transaction(function (){
            $file = new File();
            $file->fill($this->request->fileValues());

            $upload = $this->request->file('file');
            $file->path = $upload->store($file->path, [
                'disk' => $file->disk,
            ]);

            $file->checksum = $this->checksum($upload);
            $file->save();

            static::syncReferences($file, $this->request->references());

            return $file;
        });
    }

    public function checksum(UploadedFile $upload): string
    {
        return sha1_file($upload->getRealPath());
    }

    /**
     * @param File $file
     * @param array $references
     * @return File
     */
    public static function syncReferences(File $file, array $references): File
    {
        $references = collect($references)->map(fn(array $reference) => static::createOrUpdateReference($reference));

        $file->references()->sync($references->pluck('id'));

        return $file;
    }

    /**
     * @param array $values
     * @return EntityReference
     */
    public static function createOrUpdateReference(array $values): EntityReference
    {
        $reference = EntityReference::query()
            ->where('uuid', $values['uuid'])
            ->first();

        if(!$reference){
            $reference = new EntityReference();
            $reference->uuid = $values['uuid'];
        }

        $reference->fill($values);
        $reference->save();

        return $reference;
    }
}
