<?php
class SearchCest
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');

    }

    public function searchSuccessfully(AcceptanceTester $I)
    {
        $I->fillField('q', 'testing');
        $I->pressKey('#lst-ib', WebDriverKeys::ENTER);
        $I->wait(2);

        $I->seeInCurrentUrl('q=testing');
    }
    
}