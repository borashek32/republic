<?php

namespace Acceptance;

use \AcceptanceTester;

class PostCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Email', 'user@gmail.com');
        $I->fillField('Password', '22222222');
        $I->click('Log in');
        $I->see('Manage your posts');
    }

    public function userCanSeeCreatePostForm(AcceptanceTester $I)
    {
        $I->amOnPage('/dashboard/posts/create');
        $I->see('Add a new post');
    }
}
