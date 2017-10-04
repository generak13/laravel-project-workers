<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WorkersTest extends DuskTestCase
{
    /**
     * Test base workers template
     *
     * @return void
     */
    public function testIndexBaseTemplate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/workers');
            $table = $browser->element('table');

            $browser->assertSee(
                $table ? 'Here are a list of your company workers' : 'You have not any workers in your company :('
            );
            $this->assertNotNull($browser->element('#create-worker'));
        });
    }

    /**
     * Test creating new worker
     */
    public function testCreateWorkerSuccessfully()
    {
        $this->browse(function(Browser $browser) {
           $browser
            ->visit('/workers')
            ->click('#create-worker')
            ->assertSee('Create new worker')

            ->type('first_name', 'Stepan')
            ->type('last_name', 'Molot')
            ->type('email', 'molot_stepan@gmail.com')
            ->type('description', 'My description')
            ->type('resume', 'Empty resume')
            ->keys('#birthday', '09221992') //we cannot use method type for dates. Currently there is a bug in Dusk

            ->click('#add-worker')

            ->assertSee('Worker has been saved successfully')
            ->assertSee('Back to workers list');
        });
    }

    /**
     * Test create worker form validator
     */
    public function testCreateWorkerFailedValidation()
    {
        $this->browse(function(Browser $browser) {
            $browser
                ->visit('/workers')
                ->click('#create-worker')
                ->assertSee('Create new worker')

                ->type('first_name', 'Stepan')
                //skip setting last_name
                ->type('email', 'molot_stepan@gmail.com')
                ->type('description', 'My description')
                ->type('resume', 'Empty resume')
                ->keys('#birthday', '09221992') //we cannot use method type for dates. Currently there is a bug in Dusk

                ->click('#add-worker');

            $this->assertNotNull($browser->element('.form-errors'));
        });
    }

    /**
     * Test show worker info
     */
    public function testShowWorker()
    {
        $this->browse(function(Browser $browser) {
            $browser
                ->visit('/workers')
                ->click('.show-worker')

                ->assertSee('Details:')
                ->assertSee('Back to workers list');
        });
    }

    /**
     * Test edit worker
     */
    public function testEditWorker()
    {
        $this->browse(function(Browser $browser) {
            $browser
                ->visit('/workers')
                ->click('.edit-worker')
                ->assertSee('Edit company worker')

                ->type('first_name', 'Stepan')
                ->type('last_name', 'Molotok')
                ->type('email', 'molot_stepan@gmail.com')
                ->type('description', 'My description')
                ->type('resume', 'Empty resume')
                ->keys('#birthday', '09221992') //we cannot use method type for dates. Currently there is a bug in Dusk

                ->click('#edit-worker')

                ->assertSee('Worker has been saved successfully')
                ->assertSee('Back to workers list');
        });
    }

    /**
     * Test delete worker
     */
    public function testDeleteWorker()
    {
        $this->browse(function(Browser $browser) {
            $browser
                ->visit('/workers')
                ->click('.delete-worker')

                ->assertSee('Worker was retired!')
                ->assertSee('Back to workers list');
        });
    }
}
