<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FileType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTypeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_file_types()
    {
        $fileTypes = FileType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('file-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.file_types.index')
            ->assertViewHas('fileTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_file_type()
    {
        $response = $this->get(route('file-types.create'));

        $response->assertOk()->assertViewIs('app.file_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_file_type()
    {
        $data = FileType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('file-types.store'), $data);

        $this->assertDatabaseHas('file_types', $data);

        $fileType = FileType::latest('id')->first();

        $response->assertRedirect(route('file-types.edit', $fileType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_file_type()
    {
        $fileType = FileType::factory()->create();

        $response = $this->get(route('file-types.show', $fileType));

        $response
            ->assertOk()
            ->assertViewIs('app.file_types.show')
            ->assertViewHas('fileType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_file_type()
    {
        $fileType = FileType::factory()->create();

        $response = $this->get(route('file-types.edit', $fileType));

        $response
            ->assertOk()
            ->assertViewIs('app.file_types.edit')
            ->assertViewHas('fileType');
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

        $response = $this->put(route('file-types.update', $fileType), $data);

        $data['id'] = $fileType->id;

        $this->assertDatabaseHas('file_types', $data);

        $response->assertRedirect(route('file-types.edit', $fileType));
    }

    /**
     * @test
     */
    public function it_deletes_the_file_type()
    {
        $fileType = FileType::factory()->create();

        $response = $this->delete(route('file-types.destroy', $fileType));

        $response->assertRedirect(route('file-types.index'));

        $this->assertDeleted($fileType);
    }
}
