<?php

namespace SlothDevGuy\Files\Actions\Files;

use SlothDevGuy\Files\Models\File;
use Symfony\Component\HttpFoundation\Response;

trait FileAggregateRootResponse
{
    /**
     * @var File
     */
    protected File $file;

    /**
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public function response(int $code = Response::HTTP_OK, array $headers = []): Response
    {
        return response(static::map($this->file), $code, $headers);
    }

    /**
     * Maps the given File object to an array with additional data.
     *
     * @param File $file The File object to be mapped.
     * @return array The mapped array with additional data.
     */
    public static function map(File $file): array
    {
        return array_merge($file->toArray(), [
            'uuid' => $file->uuid->toString(),
        ]);
    }
}
