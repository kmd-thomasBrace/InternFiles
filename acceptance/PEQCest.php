<?php


class PEQCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/policing-education-qualifications/');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests

    public function tryToTestThePEQPageLoads(AcceptanceTester $I)
    {
        $I->see('Recognition of Prior Experience and Learning Opportunities');
    }

    public function tryToTestCaseStudiesPageLoadsAndAtLeastOneCaseStudy(AcceptanceTester $I)
    {
        $I->click('a:contains("Case Studies")');
        $I->see('Case Studies','h1');
        $numOfCaseStudies = count($I->grabMultiple('.u-tablet-one-half .c-section-link'));
        $I->assertGreaterThan(0,$numOfCaseStudies);
    }

    private function testDirectoryFilters(AcceptanceTester $I,$filterName)
    {
        $I->click('a:contains("Directory")');
        $originalResults = $I->grabMultiple('.c-course-listing');
        $filters = $I->grabMultiple('#-'.$filterName.'-filter input','value');
        //check each filter then check if the number of results shown is equal to the number of results with no filters
        foreach ($filters as $filter)
        {
            $I->click('input[value="'.$filter.'"]');
        }
        $I->click('Apply');
        $newResults = $I->grabMultiple('.c-course-listing');
        $I->assertEquals($originalResults,$newResults);
    }

    public function tryToTestDirectoryGeographyFilters(AcceptanceTester $I)
    {
        $this->testDirectoryFilters($I,'geography');
    }

    public function tryToTestDirectorySubjectAreaFilters(AcceptanceTester $I)
    {
        $this->testDirectoryFilters($I,'subject-area');
    }

    public function tryToTestDirectoryCourseCostFilters(AcceptanceTester $I)
    {
        $this->testDirectoryFilters($I,'cost-band');
    }

    public function tryToTestAllFiltersReduceNumberOfResults(AcceptanceTester $I)
    {
        $I->click('a:contains("Directory")');
        $originalResults = $I->grabMultiple('.c-course-listing');
        $filters = $I->grabMultiple('input[type=checkbox]','id');
        $radioName = $I->grabMultiple('input[type=radio]','name');
        $radioValue = $I->grabMultiple('input[type=radio]','value');
        //check each radio option decreases the number of results
        for ($j=0;$j<count($radioValue);$j++)
        {
            if (strpos($radioValue[$j], 'mobile') === false) {
                $I->selectOption('input[name="'.$radioName[$j].'"]',$radioValue[$j]);
                $I->click('Apply');
                $newResults = $I->grabMultiple('.c-course-listing');
                $I->assertLessThanOrEqual($originalResults,$newResults);
                $I->click('Clear');
            }
        }
        //check each checkbox option decreases the number of results
        foreach ($filters as $filter)
        {
            if (strpos($filter, 'mobile') === false) {
                $I->checkOption('input[id="'.$filter.'"]');
                $I->click('Apply');
                $newResults = $I->grabMultiple('.c-course-listing');
                $I->assertLessThanOrEqual($originalResults,$newResults);
                $I->click('Clear');
            }
        }
    }
    public function tryToTestCreditEstimatorWithNoSkillsAndNoTraining(AcceptanceTester $I)
    {
        $I->click('a:contains("Credit Estimator")');
        $I->see('Credit Estimator','h1');
        $I->click('Get Started');
        $I->see('Current Role','h1');
        $I->click('button[name=role]');
        $I->see('Advanced Standings/Skill Sets','h1');
        $I->click('Continue');
        $I->see('Completed Training','h1');
        $I->click('Submit');
        $I->see('Summary','h1');
        $I->dontSee('Credits','p');
        $I->dontSee('Advanced Standing/Skill Sets','h3');
        $I->dontSee('Completed Training','h3'); 
    }

    public function tryToTestCreditEstimatorWithAllSkillsAndAllTrainingAndTestIfCreditsInSummaryEqualToCreditsInDirectory(AcceptanceTester $I)
    {
        $I->click('a:contains("Credit Estimator")');
        $I->see('Credit Estimator','h1');
        $I->click('Get Started');
        $I->see('Current Role','h1');
        $I->click('button[name=role]');
        $I->see('Advanced Standings/Skill Sets','h1');
        //gets id of every skill and uses id to check the checkbox of each skill
        $skills = $I->grabMultiple('input[name="skills[]"]','id');
        codecept_debug($skills);
        for ($j=0;$j<count($skills);$j++)
        {
            $I->checkOption('input[id='.$skills[$j].']');
        }
        $I->click('Continue');
        $I->see('Completed Training','h1');
        //gets id of every course and uses id to check the checkbox of each course
        $trainings = $I->grabMultiple('input[name="courses[]"]','id');
        codecept_debug($trainings);
        for ($j=0;$j<count($trainings);$j++)
        {
            $I->checkOption('input[id='.$trainings[$j].']');
        }
        $I->click('Submit');
        $I->see('Summary','h1');
        //check if number of skills and courses that have been selected are equal to that on the summary page
        $summaryTrainings = $I->grabMultiple('.u-margin-bottom:nth-child(6) .c-split-panel__content');
        $summarySkills = $I->grabMultiple('.u-margin-bottom:nth-child(8) .c-split-panel__content');
        $I->see('Credits','p');
        $I->see('Advanced Standing/Skill Sets','h3');
        $I->see('Completed Training','h3'); 
        //check the number of skills and training selected is equal to the number on the summary page
        $I->assertEquals(count($skills),count($summarySkills));
        $I->assertEquals(count($trainings),count($summaryTrainings));
        //retrieve number of credits on the summary page
        $creditsSummary = $I->grabMultiple('p:contains("Credits")');
        $creditsSummaryNumber = 0;
        foreach ($creditsSummary as $credit ) {
            codecept_debug((int)$credit);
            $creditsSummaryNumber = $creditsSummaryNumber + (int)$credit;
        }
        $I->click('a:contains("See Available Courses")');
        $creditsDirectory = (int)($I->grabTextFrom('p:contains("Credits")'));
        codecept_debug($creditsDirectory);
        //check number of credits on the summary page equals number of credits on the directory page
        $I->assertEquals($creditsSummaryNumber,$creditsDirectory);
    }

    public function tryToTestInfoGuidancePageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Information and Guidance")');
        $I->see('Information and Guidance','h1');
    }
    
    public function tryToTestGuidanceIndividualPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Information and Guidance")');
        $I->click('a:contains("Guidance for Individuals")');
        $I->see('Guidance for Individuals','h1');
    }

    public function tryToTestGuidanceForcesPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Information and Guidance")');
        $I->click('a:contains("Guidance for Forces")');
        $I->see('Guidance for Forces','h1');
    }

    public function tryToTestGuidanceHigherEducationPageLoads(AcceptanceTester $I)
    {
        $I->click('a:contains("Information and Guidance")');
        $I->click('a:contains("Guidance for Higher Education Providers")');
        $I->see('Guidance for Higher Education Providers','h1');
    }
}