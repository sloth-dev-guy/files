<?php

namespace SlothDevGuy\Files\Actions\Files;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use SlothDevGuy\Files\Http\Requests\Files\DeleteFileRequest;

class DeleteFileAction
{
    public function __construct(
        protected readonly DeleteFileRequest $request
    )
    {

    }

    public function execute(): void
    {
        DB::transaction(function (){
            $file = UpdateFileAction::findFile($this->request->route('file'));
            if($removeAt = $this->request->validated('remove_at')) {
                $file->remove_at = $removeAt;
                $file->save();
            }

            $file->delete();

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
