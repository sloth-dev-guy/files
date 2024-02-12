<?php

namespace SlothDevGuy\Files\Actions\Files;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SlothDevGuy\Files\Models\File;

class DestroyFileAction
{
    protected File $file;

//    public function setFile(File $file): void
//    {
//        $this->file = $file;
//    }

    public function execute(): void
    {
        DB::transaction(function (){
            $file = $this->file ?? UpdateFileAction::findFile(request()->route('file'), true);

            Storage::disk($file->disk)->delete($file->path);

            $file->references()->detach();
            $file->forceDelete();

            return $file;
        });
    }

    /**
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public function response(int $code = Response::HTTP_NO_CONTENT, array $headers = []): Response
    {
        return response(null, $code, $headers);
    }
}
