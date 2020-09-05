<?php

namespace Modules\User\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Modules\User\Entities\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Access tokens.
     *
     * @var string
     */
    protected $token = [];

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('passport:install');

        $this->token['superuser'] = factory(User::class)->create()->createToken('TokenSuperuserTest')->accessToken;
    }

    /**
     * Test it can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItCanCreateResource()
    {
        if (!Route::has('user.users.store')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $password = 'secret';
        $values = factory(User::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => "application/json",
        ])->post(route('user.users.store'), array_merge($values, [
            'password' => $password,
        ]));

        $data = $response->json();

       // $this->assertTrue(Hash::check($password, User::find($data['data']['id'])->password));
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Structure of response resource.
     *
     * @return array
     */
    private function jsonStructure()
    {
        return [
            'data' => [
                'id', 'name', 'email', 'birthdate', 'created_at', 'updated_at',
            ],
        ];
    }

    /**
     * Test it can display a listing of the resource.
     *
     * @return void
     */
    public function testItCanListingResource()
    {
        if (!Route::has('user.users.index')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $amount = 1;
        $total = $amount + 1; // User authenticated

        factory(User::class, $amount)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => "application/json",
        ])->get(route('user.users.index'));

        $first = current($response->json('data'));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($total, $response->json('meta.total'));
        foreach ($this->jsonStructure()['data'] as $key) {
            $this->assertArrayHasKey($key, $first);
        }
    }

    /**
     * Test it can show the specified resource.
     *
     * @return void
     */
    public function testItCanShowResource()
    {
        if (!Route::has('user.users.show')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $entity = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => "application/json",
        ])->get(route('user.users.show', ['user' => $entity->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can update the specified resource in storage.
     *
     * @return void
     */
    public function testItCanUpdateResource()
    {
        if (!Route::has('user.users.update')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $entity = factory(User::class)->create();

        $values = factory(User::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => "application/json",
        ])->put(route('user.users.update', ['user' => $entity->id]), $values);

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($data['data'][$key], $value);
        }

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource()
    {
        if (!Route::has('user.users.destroy')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $entity = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => "application/json",
        ])->delete(route('user.users.destroy', ['user' => $entity->id]));
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
