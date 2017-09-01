<?php


class CompetencyValuesCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/competency-values/');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests

    public function tryToTestTheCompetencyValuesPageLoads(AcceptanceTester $I)
    {
        $I->see('Resolute, Compassionate and Committed');
    }

    public function tryToTestIntegrityPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Integrity")');
        $I->see('Integrity', 'h1');
    }

    public function tryToTestImpartialityPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Impartiality")');
        $I->see('Impartiality', 'h1');
    }

    public function tryToTestPublicServicePageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Public Service")');
        $I->see('Public Service', 'h1');
    }

    public function tryToTestTransparencyPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Transparency")');
        $I->see('Transparency', 'h1');
    }

    public function tryToTestEmotionallyAwarePageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("We Are Emotionally Aware")');
        $I->see('We Are Emotionally Aware', 'h1');
    }

    public function tryToTestOwnershipPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("We Take Ownership")');
        $I->see('We Take Ownership', 'h1');
    }

    public function tryToTestCollaborativePageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("We Are Collaborative")');
        $I->see('We Are Collaborative', 'h1');
    }

    public function tryToTestDeliverSupportInspirePageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("We Deliver, Support and Inspire")');
        $I->see('We Deliver, Support and Inspire', 'h1');
    }

    public function tryToTestAnalyseCriticallyPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("We Analyse Critically")');
        $I->see('We Analyse Critically', 'h1');
    }

    public function tryToTestInnovativeAndOpenMindedPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("We Are Innovative and Open Minded")');
        $I->see('We Are Innovative and Open Minded', 'h1');
    }
}
