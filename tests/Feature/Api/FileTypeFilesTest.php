<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\File;
use App\Models\FileType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTypeFilesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_file_type_files()
    {
        $fileType = FileType::factory()->create();
        $files = File::factory()
            ->count(2)
            ->create([
                'file_type_id' => $fileType->id,
            ]);

        $response = $this->getJson(
            route('api.file-types.files.index', $fileType)
        );

        $response->assertOk()->assertSee($files[0]->file_name);
    }

    /**
     * @test
     */
    public function it_stores_the_file_type_files()
    {
        $fileType = FileType::factory()->create();
        $data = File::factory()
            ->make([
                'file_type_id' => $fileType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.file-types.files.store', $fileType),
            $data
        );

        $this->assertDatabaseHas('files', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $file = File::latest('id')->first();

        $this->assertEquals($fileType->id, $file->file_type_id);
    }
}
