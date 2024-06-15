<?php

namespace Tests\Unit;

use App\Models\Manual;
use Tests\TestCase;

class ManualTest extends TestCase
{
    /** @test */
    public function a_manual_has_a_title() {
        $manual = Manual::factory()->createOne();

        $this->assertNotEmpty($manual);
    }

    /** @test */
    public function a_manual_has_a_description() {
        $manual = Manual::factory()->createOne();

        $this->assertNotEmpty($manual->description);
    }

    /** @test */
    public function a_manual_has_a_duration() {
        $manual = Manual::factory()->createOne();

        $this->assertNotEmpty($manual->duration);
    }


}
