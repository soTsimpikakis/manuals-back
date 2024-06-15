<?php

namespace Tests\Unit;

use App\Models\Manual;
use App\Models\Material;
use Tests\TestCase;

class MaterialTest extends TestCase
{
    private $manual;

    protected function setUp(): void {
        parent::setUp();

        $this->manual = Manual::factory()->createOne();

    }

    /** @test */
    public function a_material_has_a_name() {
        $mat = Material::factory()->for($this->manual, 'materialable')->createOne();

        $this->assertNotEmpty($mat->name);
    }

    /** @test */
    public function a_material_has_a_quantity() {
        $mat = Material::factory()->for($this->manual, 'materialable')->createOne();

        $this->assertNotEmpty($mat->quantity);
    }

    /** @test */
    public function a_material_has_a_unit() {
        $mat = Material::factory()->for($this->manual, 'materialable')->createOne();

        $this->assertNotEmpty($mat->unit);
    }


}
