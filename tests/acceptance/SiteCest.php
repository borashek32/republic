<?php

class SiteCest
{
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Posts List');
    }

    // public function onePostPageWorks(AcceptanceTester $I)
    // {
    //     // create record and get its id
    //     $id = $I->haveRecord('posts', [
    //         'title' => 'My first blogpost', 
    //         'body' => 'normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sa
    //             [Content too long to display. See complete response in directory',
    //         'user_id' => 3
    //     ]);
    //     $I->amOnPage('posts/'.$id);
    //     $I->see('My first blogpost', 'MIT License');
    //     // check record exists
    //     $I->seeRecord('posts', [
    //         'id' => $id
    //     ]);
    //     $I->click('Delete');
    //     // record was deleted
    //     $I->dontSeeRecord('posts', [
    //         'id' => $id
    //     ]);
    // }
}
