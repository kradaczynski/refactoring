<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_see_index_page()
    {
        $user = User::factory()->create();
        $response = $this->get(route('welcome.page'));

        $response->assertSee($user->name);
        $response->assertSuccessful();
        $response->assertViewIs('welcome');
        $response->assertViewHas('users');
    }

    public function test_can_see_create_view()
    {
        $response = $this->get(route('user.create'));

        $response->assertSuccessful();
        $response->assertViewIs('user.create-edit');
    }

    public function test_user_can_be_created()
    {
        $user = User::factory()->make();
        $response = $this->post(route('user.store'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    public function test_can_see_edit_page()
    {
        $user = User::factory()->create();
        $response = $this->get(route('user.edit', ['user' => $user->id]));

        $response->assertSuccessful();
        $response->assertSee($user->name);
        $response->assertViewIs('user.create-edit');
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->delete(route('user.destroy', ['user' => $user->id]));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }

    public function test_user_can_be_edited()
    {
        $user = User::factory()->create();
        $response = $this->put(route('user.update', ['user' => $user->id]), [
            'name' => 'newName',
            'email' => 'newEmail@mail.com'
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['name' => 'newName']);
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }

    public function test_error_when_password_not_confirmed_when_creating_user()
    {
        $user = User::factory()->make();
        $response = $this->post(route('user.store'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => 'passwd'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }

    public function test_error_when_email_not_unique_when_creating_user()
    {
        $addedUser = User::factory()->create();
        $user = User::factory()->make();
        $response = $this->post(route('user.store'), [
            'name' => $user->name,
            'email' => $addedUser->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }

    public function test_error_when_name_is_empty_when_creating_user()
    {
        $user = User::factory()->make();
        $response = $this->post(route('user.store'), [
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }

    public function test_error_when_email_is_empty_when_creating_user()
    {
        $user = User::factory()->make();
        $response = $this->post(route('user.store'), [
            'name' => $user->name,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }
}
