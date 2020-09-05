<?php

namespace Modules\User\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Services\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected $userService;

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

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $password = 'secret';
        $values = factory(User::class)->make(['password' => $password])->toArray();

        $entity = $this->userService->create(array_merge(
            $values,
            ['password' => $password]
        ));
        $data = $entity->toArray();

        $this->assertDatabaseHas('user_users', $values);
        $this->assertInstanceOf(User::class, $entity);
        $this->assertTrue(Hash::check($password, bcrypt($entity->password)));

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Structure of response entity.
     *
     * @return array
     */
    private function dataStructure()
    {
        return [
            'id', 'name', 'email', 'birthdate', 'created_at', 'updated_at',
        ];
    }

    /**
     * Test it can display a listing of the entity.
     *
     * @return void
     */
    public function testItCanListingEntity()
    {
        $amount = 2;
        factory(User::class, $amount)->create();

        $list = $this->userService->paginate();
        $data = current($list->items())->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $list);
        $this->assertEquals($amount, $list->total());

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can show the specified entity.
     *
     * @return void
     */
    public function testItCanShowEntity()
    {
        $fake = factory(User::class)->create();
        $entity = $this->userService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(User::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can update the specified entity in storage.
     *
     * @return void
     */
    public function testItCanUpdateEntity()
    {
        $password = 'secret_updated';
        $entity = factory(User::class)->create(['password' => 'secret']);
        $values = factory(User::class)->make(['password' => $password])->toArray();


        $this->userService->update(array_merge(
            $values,
            ['password' => $password]
        ), $entity->id);

        $this->assertDatabaseHas('user_users', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(User::class)->create();

        $response = $this->userService->delete($entity->id);

        $this->assertTrue($response);
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
