<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\PostActiveEnum;
use App\Models\User;
use Tests\TestCase;

final class PostDTOTest extends TestCase
{
    private User $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_to_store_new_post()
    {
        $this->postJson(route('posts-dto.store'), [
            'title' => 'this is a post',
            'content' => 'this is a content',
            'active' => PostActiveEnum::ACTIVE->value,
        ])->assertCreated();
    }
}