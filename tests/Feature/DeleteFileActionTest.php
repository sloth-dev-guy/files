<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use SlothDevGuy\Files\Models\File;
use Tests\TestCase;

class DeleteFileActionTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeleteFile(): void
    {
        /** @var File $file */
        $file = File::factory()->create();

        $response = $this->delete(route('files.delete', $file->uuid));
        $response->assertNoContent();

        $this->assertDatabaseMissing('file', [
            'uuid' => $file->uuid,
            'deleted_at' => null,
        ]);
    }

    public function testDeleteFileWithRemoveAt(): void
    {
        /** @var File $file */
        $file = File::factory()->create();

        $response = $this->delete(route('files.delete', $file->uuid), [
            'remove_at' => $removeAt = now(),
        ]);
        $response->assertNoContent();

        $this->assertDatabaseMissing('file', [
            'uuid' => $file->uuid,
            'deleted_at' => null,
        ]);

        $file = $file->fresh();
        $this->assertNotNull($file->remove_at);
        $this->assertEquals($removeAt->getTimestamp(), $file->remove_at->getTimestamp());
    }
}
