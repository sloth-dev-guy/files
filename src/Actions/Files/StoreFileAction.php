<?php

namespace SlothDevGuy\Files\Actions\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use SlothDevGuy\Files\Http\Requests\Files\StoreFileRequest;
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
            $file->fill($this->request->validated());

            $upload = $this->request->file('file');
            $upload->store($file->path, [
                'disk' => $file->disk,
            ]);

            $file->checksum = $this->checksum($upload);
            $file->save();

            return $file;
        });
    }

    public function checksum(UploadedFile $upload): string
    {
        return sha1_file($upload->getRealPath());
    }
}
