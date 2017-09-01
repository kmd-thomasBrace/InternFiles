<?php


class ProProfilesCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/professional-profiles');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    private function testProProfilesPageLoads(AcceptanceTester $I)
    {
        $I->see('Professional Profiles','h1');
    }
    
    private function testEachPathInSpecificLevel(AcceptanceTester $I, $level)
    {
        //each value in the job family array contains the number of sub groups in each job family
        $jobFamilySubGroups = array();
        $I->click('Choose Role');
        $I->click($level);
        //get text values for each job family
        $jobFamilies = ($I->grabMultiple('.c-block-link__text'))[0];
        //get the value for each job family sub group
        for ($j=0;$j<count($jobFamilies);$j++)
        {
            $I->amOnPage('/professional-profiles');
            $I->click('Choose Role');
            $I->click($level);
            $I->click(trim($jobFamilies[$j]));
            $jobFamilySubGroups[$jobFamilies[$j]] = ($I->grabMultiple('.c-block-link__text'))[0];
        }
        codecept_debug($jobFamilySubGroups);

        //loop through each jobfamily and job sub family and see if they end up on the specific role screen
        foreach ($jobFamilySubGroups as $key => $value)
        {
            for ($j=0;$j<count($value);$j++)
            {
                $I->amOnPage('/professional-profiles');
                $I->click('Choose Role');
                $I->click($level);
                $I->click(trim($key));
                $I->click(trim($value[$j]));
                $I->see("Select your ‘Specific Role’");
            }
        }
    }

    private function testFirstPathInSpecificLevel(AcceptanceTester $I, $level)
    {
        $I->click('Choose Role');
        $I->see('National Level of Policing','h1');
        $I->click($level);
        $I->see('Job Families','h1');
        //get text values for first job family
        $firstjobFamily = ($I->grabMultiple('.c-block-link__text'))[0];
        $I->click(trim($firstjobFamily));
        $I->see('Job Families Sub-Groups','h1');

        $firstSubGroup = ($I->grabMultiple('.c-block-link__text'))[0];
        $I->click(trim($firstSubGroup));
        $I->see('Specific Role','h1');

        $specificRole = ($I->grabMultiple('.c-block-link__text'))[0];
        $I->click(trim($specificRole));
        $I->see('Primary Accountabilities','h2');
        
        //@TODO test pdf downloads
    }

    // tests
    public function tryToTestProfessionalProfilesLoads(AcceptanceTester $I)
    {
        $I->see('Choose Role');
    }

    public function tryToTestFirstPathInLevel1(AcceptanceTester $I)
    {
        $this->testFirstPathInSpecificLevel($I,'Level 1');
    }

    public function tryToTestFirstPathInLevel2(AcceptanceTester $I)
    {
        $this->testFirstPathInSpecificLevel($I,'Level 2');
    }

    public function tryToTestFirstPathInLevel3(AcceptanceTester $I)
    {
        $this->testFirstPathInSpecificLevel($I,'Level 3');
    }

    public function tryToTestFirstPathInLevel4(AcceptanceTester $I)
    {
        $this->testFirstPathInSpecificLevel($I,'Level 4');
    }
    
    public function tryToTestFirstPathInLevel5(AcceptanceTester $I)
    {
        $this->testFirstPathInSpecificLevel($I,'Level 5');
    }
}
