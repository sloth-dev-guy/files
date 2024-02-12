<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use SlothDevGuy\Files\Models\File;
use Tests\TestCase;

/**
 * Class DestroyFileActionTest
 * @package Tests\Feature
 */
class DestroyFileActionTest extends TestCase
{
    use DatabaseMigrations;

    public function testDestroyFile(): void
    {
        $file = $this->uploadFile();

        $response = $this->delete(route('files.destroy', $file->uuid));
        $response->assertNoContent();

        $this->assertDatabaseMissing('file', [
            'uuid' => $file->uuid,
        ]);
    }

    public function testDestroyDeletedFile(): void
    {
        $file = $this->uploadFile();
        $file->delete();

        $response = $this->delete(route('files.destroy', $file->uuid));
        $response->assertNoContent();

        $this->assertDatabaseMissing('file', [
            'uuid' => $file->uuid,
        ]);
    }

    /**
     * Uploads a file.
     *
     * @return File The uploaded file.
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    protected function uploadFile(): File
    {
        $file = UploadedFile::fake()->create('document.pdf', 32);

        $response = $this->post(route('files.store'), [
            'disk' => 'local',
            'path' => 'tests/uploads',
            'name' => $file->getFilename(),
            'file' => $file,
        ]);
        $response->assertCreated();

        return File::query()->find($response->json('id'));
    }
}
