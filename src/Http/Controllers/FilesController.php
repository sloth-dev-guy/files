<?php

namespace SlothDevGuy\Files\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use SlothDevGuy\Files\Actions\Files\StoreFileAction;
use SlothDevGuy\Files\Actions\Files\UpdateFileAction;
use SlothDevGuy\Files\Models\File;
use SlothDevGuy\Searches\Http\Actions\SearchAction;
use SlothDevGuy\Searches\Interfaces\SearchResponseSchemaInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class FilesController
 * @package SlothDevGuy\Files\Http\Controllers
 */
class FilesController extends Controller
{
    /**
     * @param SearchAction $action
     * @return SearchResponseSchemaInterface
     */
    public function search(SearchAction $action): SearchResponseSchemaInterface
    {
        $action->from(new File());

        $action->execute();

        return $action->response();
    }

    /**
     * @return array
     */
    public function show(): array
    {
        $file = UpdateFileAction::findFile(request()->route('file'));

        return StoreFileAction::map($file);
    }

    /**
     * Stores the file action.
     *
     * @param StoreFileAction $action The file action to be stored.
     * @return Response The HTTP response indicating the status of the storage operation.
     */
    public function store(StoreFileAction $action): Response
    {
        $action->execute();

        return $action->response(Response::HTTP_CREATED);
    }

    /**
     * Download a file using a StreamedResponse.
     *
     * @return StreamedResponse
     */
    public function download(): StreamedResponse
    {
        $file = UpdateFileAction::findFile(request()->route('file'));

        $disk = Storage::disk($file->disk);

        return $disk->download($file->path, $file->name);
    }
}
