<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use SlothDevGuy\Files\Models\File;
use Tests\TestCase;

class ReadFileActionTest extends TestCase
{
    use DatabaseMigrations;

    public function testSearchAll(): void
    {
        $files = File::factory(10)->create();

        $response = $this->get(route('files.index'));
        $response->assertOk();

        $response->assertJsonCount($files->count());
    }

    public function testGet(): void
    {
        $files = File::factory(10)->create();
        /** @var File $file */
        $file = $files->random();

        $response = $this->get(route('files.show', $file->id));
        $response->assertOk();

        $response->assertJson($file->toArray());
    }

    public function testDownload(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 32);

        $response = $this->post(route('files.store'), [
            'disk' => 'local',
            'path' => 'tests/uploads',
            'name' => $file->getFilename(),
            'file' => $file,
        ]);
        $response->assertCreated();

        $response = $this->get(route('files.download', $response->json('uuid')));
        $response->assertOk();

        $response->assertDownload($file->getFilename());
    }
}
