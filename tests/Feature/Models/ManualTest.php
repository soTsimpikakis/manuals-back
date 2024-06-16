<?php

namespace Tests\Feature;

use App\Models\Manual;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManualTest extends TestCase
{

    protected function genMaterials(Manual $parent = null, int $count = 5) {

        $materials = Material::factory($count);

        if(isset($parent)) {
            $materials = $materials->for($parent);
        }

        $mat = $materials->make()->toArray();

        return $mat;

    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_manual_can_be_created() {

        $manual = Manual::factory()->makeOne(
            [
                'author_id' => null
            ]
        );

        $payload = [
            'title' => $manual->title,
            'description' => $manual->description,
            'min_duration' => $manual->min_duration,
            'max_duration' => $manual->max_duration,
            // 'materials' => $this->genMaterials()
        ];

        $this->post('/api/manuals', $payload)->assertStatus(201);

        unset($payload['materials']);
        $this->assertDatabaseHas('manuals', $payload);
    }

    /** @test */
    public function a_manual_can_be_created_with_materials() {
        $manual = Manual::factory()->makeOne(
            [
                'author_id' => null
            ]
        );

        $payload = [
            'title' => $manual->title,
            'description' => $manual->description,
            'min_duration' => $manual->min_duration,
            'max_duration' => $manual->max_duration,
            'materials' => $this->genMaterials(parent: $manual, count: 5)
        ];

        $this->post('/api/manuals', $payload)->assertStatus(201);

        unset($payload['materials']);
        $this->assertDatabaseHas('manuals', $payload);
        $this->assertDatabaseCount('materials', 5);
    }

    /** @test */
    public function a_manual_can_be_created_with_materials_raw_input() {
        $manual = Manual::factory()->makeOne(
            [
                'author_id' => null
            ]
        );

        $payload = [
            'title' => $manual->title,
            'description' => $manual->description,
            'min_duration' => $manual->min_duration,
            'max_duration' => $manual->max_duration,
            'materials' => [
                [
                    'name' => 'mat',
                    'quantity' => 20,
                    'unit' => null
                ]
            ]
            // 'materials' => $this->genMaterials(parent: $manual, count: 5)
        ];

        $this->post('/api/manuals', $payload)->assertStatus(201);

        unset($payload['materials']);
        $this->assertDatabaseHas('manuals', $payload);
        $this->assertDatabaseCount('materials', 1);
    }

    /** @test */
    public function a_manual_can_be_deleted() {
        $manual = Manual::factory()->createOne();


        $this->delete("/api/manuals/$manual->id")->assertStatus(204);

        $this->assertDatabaseMissing('manuals', ['id' => $manual->id]);
    }

    /** @test */
    public function a_manual_can_be_updated() {
        $manual = Manual::factory()->createOne();

        $payload = [
            'title' => 'new title'
        ];

        $this->patch("/api/manuals/$manual->id", $payload)->assertStatus(200);

        $this->assertDatabaseMissing('manuals', [
            'id' => $manual->id,
            'title' => $manual->title
        ]);

        $this->assertDatabaseHas('manuals', [
            'id' => $manual->id,
            'title' => $payload['title']
        ]);
    }

    /** @test */
    public function a_manual_can_update_its_materials() {
        $manual = Manual::factory()->hasMaterials(3)->createOne();



    }
}
