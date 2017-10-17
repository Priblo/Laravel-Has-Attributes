<?php
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Application;
use Priblo\LaravelHasSettings\Traits\HasSettings;
use Illuminate\Support\Facades\DB;

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

        $User->createOneSetting('premium', true);
        $User->createOneSetting('address', '123 unknow st');

        $settings = $User->readAllSettings();
        $this->assertSame( $settings->premium,  '1');
        $this->assertSame( $settings->address, '123 unknow st');
    }

    /**
     * Test update setting
     */
    public function test_UpdateSetting()
    {
        $User = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $this->assertSame( $User->readOneSetting('premium'),  '1');

        $User->updateOneSetting('premium', 0);
        $this->assertSame( $User->readOneSetting('premium'),  '0');
    }

    /**
     * Test has setting
     */
    public function test_HasSetting()
    {
        $User = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $this->assertTrue( $User->hasSetting('premium'));
        $this->assertFalse( $User->hasSetting('address'));
    }

    /**
     * Test has setting
     */
    public function test_DeleteSetting()
    {
        $User = $this->createOneUser();

        $User->createOneSetting('premium', true);
        $this->assertTrue( $User->hasSetting('premium'));

        $User->deleteOneSetting('premium');
        $this->assertFalse( $User->hasSetting('premium'));
    }

    /**
     * @return User
     */
    private function createOneUser()
    {
        $User = new User();
        $User->username = 'Mr.X';
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