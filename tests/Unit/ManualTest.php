<?php

namespace Tests\Unit;

use App\Models\Manual;
use Tests\TestCase;

class ManualTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function a_manual_has_a_title() {
        $manual = Manual::factory()->makeOne();

        $this->assertNotEmpty($manual->title);
    }
}
