<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ScheduleTest extends TestCase
{
    use DatabaseTransactions;


    protected $city;
    protected $cleaner;


    protected function setUp()
    {
        parent::setUp();

        $this->city = App\City::create([
            'name' => 'Hogwarts',
        ]);

        $this->cleaner = App\Cleaner::create([
            'first_name' => 'TestFirstName',
            'last_name' => 'TestLastName',
            'quality_score' => '3.5',
        ]);

        $this->cleaner->cities()->attach($this->city->id);
    }


    /**
     * Test if schedule form works
     *
     * @return void
     */
    public function testScheduleForm()
    {
        $this->visit('/book')
             ->see('Book a cleaner')
             ->assertResponseOk();
    }

    /**
     * Test if we can't schedule a cleaning with incomplete information
     *
     * @return void
     */
    public function testIncompleteSchedule()
    {
        $this->visit('/book')
             ->type('John', 'first_name')
             ->type('Smith', 'last_name')
             ->type('+380981234567', 'phone_number')
             ->press('Book')
             ->seePageIs('/book')
             ->see('The city id field is required.');
    }

    /**
     * Test if we can schedule a cleaning
     *
     * @return void
     */
    public function testCompleteSchedule()
    {
        $this->shouldMakeSuccessfulSchedule();

        $this->assertTrue(str_contains($this->currentUri, '/book/thank-you/'));
        
        $this->see($this->cleaner->first_name);
    }


    /**
     * Test if we can schedule a cleaning
     *
     * @return void
     */
    public function testScheduleSuggestions()
    {
        $this->shouldMakeSuccessfulSchedule();

        // the second one should result in displayed suggestions
        $this->shouldMakeSuccessfulSchedule();

        $this->seePageIs('/book')
            ->see('But there are some on these dates:');
    }


    /**
     * Helper function to make a successful booking
     *
     * @return TestCase
     */ 
    private function shouldMakeSuccessfulSchedule()
    {
        return $this->visit('/book')
             ->type('John', 'first_name')
             ->type('Smith', 'last_name')
             ->type('+380981234567', 'phone_number')
             ->select($this->city->id, 'city_id')
             ->type('2019-09-03', 'date')       // FIXME: set a far-future date
             ->type('10:00', 'time')            // FIXME: set a legit time from config
             ->select('0', 'duration')
             ->press('Book');
    }    
}
