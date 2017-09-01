<?php


class HomePageCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTestTheHomePageLoads(AcceptanceTester $I)
    {
        $I->see('Search Professional Development');
    }

    public function tryToTestTheProfessionalProfilesPageLoads(AcceptanceTester $I)
    {
        $I->seeLink('Professional Profiles');
        $I->click('Professional Profiles');
        $I->see('Choose Role');
    }

    public function tryToTestSearchFunctionExpectedValue(AcceptanceTester $I)
    {
        $I->fillField('#desktop_search','a');
        $I->click('.c-input-group__addon.c-search-form__submit');
        $I->see("results for 'a'");
    }

    public function tryToTestBothSearchFunctionsAreEqual(AcceptanceTester $I)
    {
        $I->fillField('#primary_search','a');
        $I->click('.c-body-search-form--large .c-search-form__submit');
        $primarySearchPage = $I->grabFromCurrentUrl();
        $I->fillField('#desktop_search','a');
        $I->click('.c-input-group__addon.c-search-form__submit');
        $desktopSearchPage = $I->grabFromCurrentUrl();
        $I->assertEquals($primarySearchPage,$desktopSearchPage);
    }

    public function tryToTestSpecialCharactersInSearch(AcceptanceTester $I)
    {
        $specialCharacters = array(
            "'","{",'"',"<","["
            );
        foreach ($specialCharacters as $char) {
            $I->fillField('#desktop_search',$char);
            $I->click('.c-input-group__addon.c-search-form__submit');
            $I->see("for '".$char."'");
        }
    }

    public function tryToTestSearchFilters(AcceptanceTester $I)
    {       
        $I->fillField('#desktop_search','a');
        $I->click('.c-input-group__addon.c-search-form__submit');
        $filters = $I->grabMultiple('input[name="content-types[]"]','id');
        $originalResults = $I->grabMultiple('.c-search-results-group__link');
        //check each individual filter reduces the number of results
        foreach($filters as $filter)
        {
            if (strpos($filter, 'mobile') === false) {
                $I->checkOption('input[id='.$filter.']');
                $I->click('Apply');
                $newResults = $I->grabMultiple('.c-search-results-group__link');
                $I->assertLessThan(count($originalResults),count($newResults));
                $I->click('Clear');
            }
        }
        //check every filter applied equals number of original results
        foreach($filters as $filter)
        {
            if (strpos($filter, 'mobile') === false) {
                $I->checkOption('input[id='.$filter.']');
            }
        }
        $I->click('Apply');
        $newResults = $I->grabMultiple('.c-search-results-group__link');
        $I->assertEquals(count($originalResults),count($newResults));
    }

    public function tryToTestCareerPathwaysPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Career Pathways")');
        $I->see('Career Pathways', 'h1');
    }

    public function tryToTestFAQPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Frequently asked questions")');
        $I->see('Frequently asked questions', 'h1');
    }

    public function tryToTestPrivacyPolicyPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Privacy Policy")');
        $I->see('Privacy Policy', 'h1');
    }

    public function tryToTestTermsAndConditionsPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Terms and Conditions")');
        $I->see('Terms and Conditions', 'h1');
    }

    public function tryToTestLegalPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Legal")');
        $I->see('Legal', 'h1');
    }

    public function tryToTestFOIPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("FOI")');
        $I->see('FOI', 'h1');
    }

    public function tryToTestDiversityPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Diversity")');
        $I->see('Diversity', 'h1');
    }

    public function tryToTestAccessibilityPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Accessibility")');
        $I->see('Accessibility', 'h1');
    }

}
