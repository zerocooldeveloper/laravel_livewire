<?php

namespace Database\Factories;

use App\Models\FileType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FileType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mime_type' => $this->faker->mimeType(),
            'extensions' => $this->faker->fileExtension(),
        ];
    }
}
