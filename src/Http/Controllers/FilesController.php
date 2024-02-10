<?php

namespace SlothDevGuy\Files\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use SlothDevGuy\Files\Actions\Files\StoreFileAction;

class FilesController extends Controller
{
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
}
