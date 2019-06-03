<?php
class SearchCest
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');

    }

    public function searchSuccessfully(AcceptanceTester $I)
    {
        $I->fillField(['name' => 'q'], 'testing');
        $I->click('btnK');
        $I->wait(2);

        $I->seeInCurrentUrl('q=testing');
    }
    
}