<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StoreFileActionTest extends TestCase
{
    use DatabaseMigrations;

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

    public function testStoreFileWithUserAndReferences(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 32);

        $response = $this->post(route('files.store'), [
            'disk' => 'local',
            'path' => 'tests/uploads',
            'name' => $file->getFilename(),
            'file' => $file,
            'metadata' => [
                'foo' => 'bar',
                'owner' => [
                    'uuid' => fake()->uuid,
                    'name' => fake()->name,
                    'email' => fake()->email,
                ]
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
            ]
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('file', ['uuid' => $response->json('uuid')]);
        $this->assertNotEmpty($references = $response->json('references'));

        foreach ($references as $reference){
            $this->assertDatabaseHas('entity_reference', ['uuid' => $uuid = data_get($reference, 'uuid')]);
            $this->assertTrue(in_array($uuid, $uuids));
        }
    }
}
