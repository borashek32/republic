<?php

namespace Acceptance;

use \AcceptanceTester;
use Codeception\Util\ActionSequence;

class DbCest
{
    public function canBeSeenInDatabase(AcceptanceTester $I)
    {
        $I->seeInDatabase('users', [
            'name' => 'Nataly Zueva', 
            'email' => 'admin@gmail.com'
        ]);

        $I->seeInDatabase('users', [
            'name' => 'Vadim Zuev', 
            'email' => 'user@gmail.com'
        ]);
    }

    public function canSeeNumRecords(AcceptanceTester $I)
    {
        $I->seeNumRecords(1, 'users', ['name' => 'Nataly Zueva']);
        $I->seeNumRecords(1, 'users', ['name' => 'Vadim Zuev']);
    }

    public function canNotBeSeenInDatabase(AcceptanceTester $I)
    {
        $I->dontSeeInDatabase('users', [
            'name' => '1Nataly Zueva', 
            'email' => 'admin@gmail.com'
        ]);
        
        $I->dontSeeInDatabase('users', [
            'name' => '2Vadim Zuev', 
            'email' => 'user@gmail.com'
        ]);
    }

    public function canUpdateData(AcceptanceTester $I)
    {
        $I->updateInDatabase('users', array('name' => '13245678'), array('email' => 'miles@davis.com'));
    }
}
