<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Priblo\LaravelHasAttributes\Traits\HasAttributes;

/**
 * Class CommonUsageTest
 */
class TraitUsageTest extends TestCase
{
    /**
     * Test create Attributes
     */
    public function test_CreateAttributes()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneAttribute('premium', true);
        $User->createOneAttribute('address', '123 unknow st');

        $Attributes = $User->readAllAttributes();
        $this->assertSame( $Attributes->premium,  '1');
        $this->assertSame( $Attributes->address, '123 unknow st');

        $User2->createOneAttribute('premium', false);
        $User2->createOneAttribute('address', '321 unknow st');

        $Attributes = $User2->readAllAttributes();
        $this->assertSame( $Attributes->premium,  '0');
        $this->assertSame( $Attributes->address, '321 unknow st');
    }

    /**
     * Test update Attribute
     */
    public function test_UpdateAttribute()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneAttribute('premium', true);
        $this->assertSame( $User->readOneAttribute('premium'),  '1');

        $User->updateOneAttribute('premium', 0);
        $this->assertSame( $User->readOneAttribute('premium'),  '0');

        $User2->createOneAttribute('premium', 1);
        $this->assertSame( $User2->readOneAttribute('premium'),  '1');


    }

    /**
     * Test has Attribute
     */
    public function test_HasAttribute()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneAttribute('premium', true);
        $this->assertTrue( $User->hasAttribute('premium'));
        $this->assertFalse( $User->hasAttribute('address'));
        $this->assertFalse( $User2->hasAttribute('premium'));
    }

    /**
     * Test has Attribute
     */
    public function test_DeleteAttribute()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneAttribute('premium', true);
        $User2->createOneAttribute('premium', true);
        $this->assertTrue( $User->hasAttribute('premium'));

        $User->deleteOneAttribute('premium');
        $this->assertFalse( $User->hasAttribute('premium'));
        $this->assertTrue( $User2->hasAttribute('premium'));
    }

    /**
     * Test has Attribute
     */
    public function test_DeleteAllAttributes()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneAttribute('premium', true);
        $User->createOneAttribute('address', '123 unknow st');
        $User2->createOneAttribute('premium', true);
        $User2->createOneAttribute('address', '123 unknow st');

        $Attributes = $User->readAllAttributes();
        $this->assertSame( $Attributes->premium,  '1');
        $this->assertSame( $Attributes->address, '123 unknow st');

        $User->deleteAllAttributes();
        $this->assertTrue( empty((array)$User->readAllAttributes()));

        $Attributes = $User2->readAllAttributes();
        $this->assertSame( $Attributes->premium,  '1');
        $this->assertSame( $Attributes->address, '123 unknow st');

    }

    /**
     * @return User
     */
    private function createOneUser()
    {
        $User = new User();
        $User->username = uniqid();
        $User->save();

        return $User;
    }

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        // call migrations specific to our tests, e.g. to seed the db
        // the path option should be relative to the 'path.database'
        // path unless `--path` option is available.
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        Schema::create('users', function ($table) {
            $table->increments('user_id');
            $table->string('username');
            $table->timestamps();
        });
    }

    /**
     *
     */
    public function tearDown()
    {
        Schema::drop('users');
    }

    /**
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Database\ConsoleServiceProvider::class,
            \Priblo\LaravelHasAttributes\LaravelServiceProvider::class,
        ];
    }
}

/**
 * Class User
 */
class User extends Eloquent
{
    use HasAttributes;

    protected $connection = 'testbench';

    protected $table = 'users';
    protected $primaryKey = 'user_id';
}