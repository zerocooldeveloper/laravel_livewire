<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FileType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTypeTest extends TestCase
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
    public function it_gets_file_types_list()
    {
        $fileTypes = FileType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.file-types.index'));

        $response->assertOk()->assertSee($fileTypes[0]->mime_type);
    }

    /**
     * @test
     */
    public function it_stores_the_file_type()
    {
        $data = FileType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.file-types.store'), $data);

        $this->assertDatabaseHas('file_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_file_type()
    {
        $fileType = FileType::factory()->create();

        $data = [
            'mime_type' => $this->faker->text(255),
            'extensions' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.file-types.update', $fileType),
            $data
        );

        $data['id'] = $fileType->id;

        $this->assertDatabaseHas('file_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_file_type()
    {
        $fileType = FileType::factory()->create();

        $response = $this->deleteJson(
            route('api.file-types.destroy', $fileType)
        );

        $this->assertDeleted($fileType);

        $response->assertNoContent();
    }
}
