<?php

namespace Tests\Feature\Role;

use App\Rol;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use TestCase;

class CreateRoleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var string
     */
    private $url = 'rols';

    /**
     * @var
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $user = factory(User::class)->create();

        $user->roles()->attach(Config::get('constants.Administrator'));
        $this->be($user);

        session()->start();
    }

    protected function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /** @test */
    public function an_admin_can_create_a_role()
    {
        $body = [
            'name' => 'test role',
            '_token' => csrf_token(),
        ];

        $response = $this->post($this->url, $body);

        $response->assertStatus(302);

        $role = Rol::all()->last();

        $this->assertEquals($body['name'], $role->name);
    }

    /** @test */
    public function a_role_can_not_create_a_role()
    {
        $body = [
            'name' => 'test role',
            '_token' => csrf_token(),
        ];

        $this->user->roles()->detach();

        $response = $this->post($this->url, $body);

        $response->assertStatus(403);
    }

    /** @test */
    public function a_role_can_not_be_created_without_required_fields()
    {
        $body = [
            '_token' => csrf_token(),
        ];

        $response = $this->post($this->url, $body);

        $response->assertStatus(302);

        $errors = session('errors');

        $this->assertCount(1, $errors);
        $this->assertEquals("Veld name moet ingevuld zijn", $errors->get('name')[0]);
    }
}
