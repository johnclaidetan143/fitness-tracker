<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseTutorialTest extends TestCase
{
    use RefreshDatabase;

    public function test_normal_user_can_view_exercise_tutorial_videos(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/exercise-tutorials')
            ->assertOk()
            ->assertSee('Exercise Tutorials')
            ->assertSee('videos/push-up.mp4')
            ->assertSee('videos/plank.mp4')
            ->assertSee('videos/running.mp4');
    }
}
