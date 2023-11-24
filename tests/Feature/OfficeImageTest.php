<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Office;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OfficeImageTest extends TestCase
{
    /**
     * api test for  storing images for an office
     *
     * @test
     *
     * @return void
     */
    public function api_test_for_storing_images_for_an_office()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $office = Office::factory()->for($user)->create();

        $response = $this->post("/api/offices/{$office->id}/images", [
            'image' => UploadedFile::fake()->image('image.jpg'),
        ]);

        $response->assertCreated();

        Storage::disk('public')->assertExists($response->json('data.path'));

    }

    /**
     * api test for  deleting an image for an office
     *
     * @test
     *
     * @return void
     */
    public function api_test_for_deleting_an_image_for_an_office()
    {

        Storage::put('/office_image.jpg', 'empty');

        $user = User::factory()->create();
        $office = Office::factory()->for($user)->create();

        $office->images()->create([
            'path' => 'image.jpg',
        ]);

        $image = $office->images()->create([
            'path' => 'office_image.jpg',
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson("/api/offices/{$office->id}/images/{$image->id}");

        $response->assertOk();

        $this->assertModelMissing($image);

        Storage::assertMissing('office_image.jpg');

    }

    /**
     * it doesnt allow to delete the only image
     *
     * @test
     *
     * @return void
     */
    public function it_doesnt_allow_to_delete_the_only_image()
    {
        $user = User::factory()->create();

        $office = Office::factory()->for($user)->create();

        $image = $office->images()->create([
            'path' => 'office_image.jpg',
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson("/api/offices/{$office->id}/images/{$image->id}");

        $response->assertUnprocessable();

    }

    /**
     * it doesnt allow to delete the featured image
     *
     * @test
     *
     * @return void
     */
    public function it_doesnt_allow_to_delete_the_featured_image()
    {
        $user = User::factory()->create();

        $office = Office::factory()->for($user)->create();

        $image = $office->images()->create([
            'path' => 'office_image.jpg',
        ]);
        $office->images()->create([
            'path' => 'office_image.jpg',
        ]);

        $office->update(['featured_image_id' => $image->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson("/api/offices/{$office->id}/images/{$image->id}");

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['image' => 'Cannot delete the featured image.']);

    }

    /**
     * it doesnt delete image that belong to another resource
     *
     * @test
     *
     * @return void
     */
    public function it_doesnt_delete_image_that_belong_to_another_resource()
    {
        $user = User::factory()->create();

        $office = Office::factory()->for($user)->create();

        $image = $office->images()->create([
            'path' => 'office_image.jpg',
        ]);

        $another_office = Office::factory()->for($user)->create();

        $another_office->images()->create([
            'path' => 'office_image.jpg',
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson("/api/offices/{$another_office->id}/images/{$image->id}");

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['image' => 'The image does not belong to this office']);

    }
}
