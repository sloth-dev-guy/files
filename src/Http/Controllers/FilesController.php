<?php

namespace SlothDevGuy\Files\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use SlothDevGuy\Files\Actions\Files\DeleteFileAction;
use SlothDevGuy\Files\Actions\Files\DestroyFileAction;
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

    /**
     * Updates a file by executing the given update action.
     *
     * @param UpdateFileAction $action The update action to be executed.
     * @return Response The response after executing the update action.
     */
    public function update(UpdateFileAction $action): Response
    {
        $action->execute();

        return $action->response();
    }

    /**
     * Deletes a file.
     *
     * @param DeleteFileAction $action The delete file action object.
     * @return Response The response object.
     */
    public function delete(DeleteFileAction $action): Response
    {
        $action->execute();

        return $action->response();
    }

    /**
     * Restore a file.
     *
     * Restores a file by finding it with the given file ID from the request route parameter.
     * This method executes the restore action on the file and returns the mapped data using StoreFileAction::map().
     *
     * @return array                  Returns the mapped data of the restored file.
     */
    public function restore(): array
    {
        $file = UpdateFileAction::findFile(request()->route('file'), true);

        $file->restore();

        return StoreFileAction::map($file);
    }

    /**
     * Destroys a file.
     *
     * @param DestroyFileAction $action The destroy file action object.
     * @return Response The response object.
     */
    public function destroy(DestroyFileAction $action): Response
    {
        $action->execute();

        return $action->response();
    }
}
