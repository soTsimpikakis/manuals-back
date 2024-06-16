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
    public function a_manual_can_be_deleted_with_its_materials() {
        $manual = Manual::factory()->hasMaterials(5)->createOne();

        $this->assertDatabaseCount('manuals', 1);
        $this->assertDatabaseCount('materials', 5);

        $this->delete("/api/manuals/$manual->id");

        $this->assertDatabaseEmpty('manuals');
        $this->assertDatabaseEmpty('materials');
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
    public function a_manual_can_add_a_material() {

        $manual = Manual::factory()->hasMaterials(5)->createOne();

        $payload = $this->genMaterials(parent: $manual, count: 1)[0];

        $this->post("/api/manuals/$manual->id/materials", $payload);

        $manual->load(['materials']);

        $this->assertCount(6, $manual->materials);

        $this->assertDatabaseHas('materials', $payload);

    }

    /** @test */
    public function a_manual_can_remove_a_material() {

        $manual = Manual::factory()->hasMaterials(5)->createOne();

        $mat = Material::factory()->for($manual)->createOne();


        $this->assertCount(6, $manual->materials);

        $res = $this->delete("/api/manuals/$manual->id/materials/$mat->id")
            ->assertStatus(204);

        $m = $res->getOriginalContent();

        $this->assertCount(5, $m->materials);

        $this->assertDatabaseMissing('materials', ['id' => $mat->id]);
    }
}
