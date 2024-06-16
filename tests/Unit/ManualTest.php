<?php

namespace Tests\Unit;

use App\Models\Manual;
use App\Models\User;
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

    /** @test */
    public function a_manual_has_some_discussion_questions() {
        $manual = Manual::factory()->createOne();

        $this->assertNotEmpty($manual->questions);
        $this->assertGreaterThan(0, count($manual->questions));
    }

    /** @test */
    public function a_manual_can_have_no_questions() {
        $manual = Manual::factory()->createOne([
            'questions' => null
        ]);

        $this->assertEmpty($manual->questions);
    }

    /** @test */
    public function a_manual_has_an_author() {
        $manual = Manual::factory()->createOne();
        $this->assertNotEmpty($manual->author);
    }

    /** @test */
    public function a_manual_can_have_materials() {
        $manual = Manual::factory()->hasMaterials(5)->createOne();
        $this->assertNotEmpty($manual->materials);
    }
    /** @test */
    public function a_manual_can_be_a_draft() {
        $manual = Manual::factory()->createOne([
            'is_draft' => true
        ]);

        $this->assertTrue($manual->is_draft);
    }
}
