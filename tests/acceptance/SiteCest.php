<?php

use App\Models\Post;

class SiteCest
{
    public function frontPageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Posts List');
    }

    // public function onePostPageWorks(AcceptanceTester $I)
    // {
    //     $post_id = random_int(1, 30);
    //     $post    = Post::where('id', $post_id);
    //     $I->amOnPage('posts/' . $post_id);
    //     $I->see($post->title);
    // }

    public function loginPageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email');
        $I->see('Password');
    }

    public function registerPageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/register');
        $I->see('Email');
        $I->see('Password');
        $I->see('Confirm Password');
    }

    public function userCanLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Email', 'user@gmail.com');
        $I->fillField('Password', '22222222');
        $I->click('Log in');
        $I->see('Manage your posts');
    }

    public function adminCanLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Email', 'admin@gmail.com');
        $I->fillField('Password', '11111111');
        $I->click('Log in');
        $I->see('Manage all posts');
        $I->see('Users');
    }

    
}
