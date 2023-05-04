<?php

namespace Tests\Feature;

use Tests\TestCase;

class TagsControllerTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function tags_list()
    {
        $response = $this->get('/api/tags');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

    }
}
