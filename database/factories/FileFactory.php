<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SlothDevGuy\Files\Models\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<File>
 */
class FileFactory extends Factory
{
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'disk' => 'local',
            'path' => $this->faker->filePath(),
            'name' => $this->faker->name,
            'checksum' => md5($this->faker->uuid),
            'metadata' => [],
        ];
    }
}
