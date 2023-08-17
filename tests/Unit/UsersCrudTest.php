<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UsersCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a new user can be created.
     */

    public function test_retrieve_all_user()
    {
        // $user = User::factory()->create();
        // $token = $user->createToken('authToken')->plainTextToken;
        // $this->withHeader('Authorization', 'Bearer ' . $token);
        // $this->actingAs($user, 'api');
        // $response = $this->get('/api/users');
        // $response->assertStatus(200);
        // $response->assertJson($user->toArray());
    $user = User::factory()->create();
    $token = $user->createToken('authToken')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->actingAs($user, 'api')->get('/api/users');

    $response->assertStatus(200)
        ->assertJson([$user->toArray()]);
    }

    public function test_can_create_new_user()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer ' . $token);
        $this->actingAs($user, 'api');
        $response = $this->post('api/users', [
            'name' => "Arief",
            'email' => "arief@gmail.com",
        ]);

        $response->assertSuccessful(); //mengecek apakah statusnya >200
        $this->assertDatabaseHas('users', [
            'name' => "Arief",
            'email' => "arief@gmail.com",
        ]); //cek apakah data yang di masukkan sama dengan data yang ditabase
    }

    /**
     * Test that a user can be retrieved by their ID.
     */
    public function test_can_retrieve_user_by_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer ' . $token);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJson($user->toArray());
    }

    /**
     * Test that a user can be updated.
     */
    public function test_can_update_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer ' . $token);
        $this->actingAs($user, 'api');
        $response = $this->put('api/users/' . $user->id, [
            'name' => "Arief",
            'email' => "update@gmail.com",
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas('users', [
            'name' => "Arief",
            'email' => "update@gmail.com",
        ]);
    }

    /**
     * Test that a user can be deleted.
     */
    public function test_can_delete_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer ' . $token);
        $this->actingAs($user, 'api');
        $response = $this->delete('api/users/' . $user->id);
        $response->assertSuccessful();
        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
