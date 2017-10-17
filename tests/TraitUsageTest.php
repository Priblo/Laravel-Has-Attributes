<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Priblo\LaravelHasSettings\Traits\HasSettings;

/**
 * Class CommonUsageTest
 */
class TraitUsageTest extends TestCase
{
    /**
     * Test create settings
     */
    public function test_CreateSettings()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $User->createOneSetting('address', '123 unknow st');

        $settings = $User->readAllSettings();
        $this->assertSame( $settings->premium,  '1');
        $this->assertSame( $settings->address, '123 unknow st');

        $User2->createOneSetting('premium', false);
        $User2->createOneSetting('address', '321 unknow st');

        $settings = $User2->readAllSettings();
        $this->assertSame( $settings->premium,  '0');
        $this->assertSame( $settings->address, '321 unknow st');
    }

    /**
     * Test update setting
     */
    public function test_UpdateSetting()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $this->assertSame( $User->readOneSetting('premium'),  '1');

        $User->updateOneSetting('premium', 0);
        $this->assertSame( $User->readOneSetting('premium'),  '0');

        $User2->createOneSetting('premium', 1);
        $this->assertSame( $User2->readOneSetting('premium'),  '1');


    }

    /**
     * Test has setting
     */
    public function test_HasSetting()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $this->assertTrue( $User->hasSetting('premium'));
        $this->assertFalse( $User->hasSetting('address'));
        $this->assertFalse( $User2->hasSetting('premium'));
    }

    /**
     * Test has setting
     */
    public function test_DeleteSetting()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $User2->createOneSetting('premium', true);
        $this->assertTrue( $User->hasSetting('premium'));

        $User->deleteOneSetting('premium');
        $this->assertFalse( $User->hasSetting('premium'));
        $this->assertTrue( $User2->hasSetting('premium'));
    }

    /**
     * Test has setting
     */
    public function test_DeleteAllSettings()
    {
        $User = $this->createOneUser();
        $User2 = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $User->createOneSetting('address', '123 unknow st');
        $User2->createOneSetting('premium', true);
        $User2->createOneSetting('address', '123 unknow st');

        $settings = $User->readAllSettings();
        $this->assertSame( $settings->premium,  '1');
        $this->assertSame( $settings->address, '123 unknow st');

        $User->deleteAllSettings();
        $this->assertTrue( empty((array)$User->readAllSettings()));

        $settings = $User2->readAllSettings();
        $this->assertSame( $settings->premium,  '1');
        $this->assertSame( $settings->address, '123 unknow st');

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
            \Priblo\LaravelHasSettings\LaravelServiceProvider::class,
        ];
    }
}

/**
 * Class User
 */
class User extends Eloquent
{
    use HasSettings;

    protected $connection = 'testbench';

    protected $table = 'users';
    protected $primaryKey = 'user_id';
}