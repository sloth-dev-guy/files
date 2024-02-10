<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StoreFileActionTest extends TestCase
{
    public function testStoreFile(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 32);

        $response = $this->post(route('files.store'), [
            'disk' => 'local',
            'path' => 'tests/uploads',
            'name' => $file->getFilename(),
            'file' => $file,
            'metadata' => [
                'foo' => 'bar',
            ]
        ]);
        $response->assertCreated();

        $values = $response->json();
        $this->assertDatabaseHas('file', ['uuid' => data_get($values, 'uuid')]);
    }
}
