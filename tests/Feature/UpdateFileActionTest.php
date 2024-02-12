<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use SlothDevGuy\Files\Models\File;
use Tests\TestCase;

class UpdateFileActionTest extends TestCase
{
    use DatabaseMigrations;

    public function testUpdateFile(): void
    {
        /** @var File $file */
        $file = File::factory()->create();

        $response = $this->put(route('files.update', $file->uuid), [
            'name' => Str::random() . '.pdf',
            'metadata' => [
                'foo' => 'bar'
            ],
            'references' => [
                [
                    'service' => 'test',
                    'uuid' => $uuids[] = fake()->uuid,
                    'entity_type' => 'FooClass',
                    'entity_id' => rand(1, 999),
                ],
                [
                    'service' => 'test',
                    'uuid' => $uuids[] = fake()->uuid,
                    'entity_type' => 'BarClass',
                    'entity_id' => rand(1, 999),
                ],
            ],
        ]);
        $response->assertOk();

        $response->assertJson($file->fresh()->toArray());
        $this->assertNotEmpty($references = $response->json('references'));

        foreach ($references as $reference){
            $this->assertDatabaseHas('entity_reference', ['uuid' => $uuid = data_get($reference, 'uuid')]);
            $this->assertTrue(in_array($uuid, $uuids));
        }
    }


    public function testRestoreFile(): void
    {
        /** @var File $file */
        $file = File::factory()->create();
        $file->delete();

        $response = $this->put(route('files.restore', $file->uuid));
        $response->assertOk();

        $this->assertDatabaseHas('file', [
            'uuid' => $file->uuid,
            'deleted_at' => null,
        ]);
    }
}
