<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    
    /*
    * testing for api store post
    * @test
    * @return void
    */
    public function test_post_store()
    {
        $user = User::factory()->create();

        $tags = Tag::factory(2)->create();
        

        $this->actingAs($user);

        $url = route('posts.store');
        
        $response = $this->postJson($url, [
                'title'         => 'this is a post',
                'content'       => 'this is a content',
                'tags'          => $tags->pluck('id'),
        ]);
        $response->assertStatus(201);
        $response->assertJsonPath('data.tags.0.id', $tags[0]->id)
        ->assertJsonPath('data.tags.1.id', $tags[1]->id)
        ->assertJsonPath('data.title', 'this is a post')
        ->assertJsonPath('data.content', 'this is a content');
    }


    /**
     * @test
     * @dataProvider validationProvider
     */
     public function validationTests(array $payload, string $key)
     {
        $response = $this->postJson(route('posts.store'), $payload);
        $response->assertSessionHasErrors($key);
     }

        public function validationProvider(): Generator
        {
            $defaultPayload = [
                "title" => "this is a post",
                "content" => "this is a content",
            ];

            yield 'title is required' => [
                array_merge($defaultPayload, ['title' => '']),
                'title'
            ];
        }
}
