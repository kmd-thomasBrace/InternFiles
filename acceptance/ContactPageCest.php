<?php


class ContactPageCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/Contact-Us');
    }

    public function _after(AcceptanceTester $I)
    {
    }
    //default function that fills the contact us page with correct values for each input
    private function fillContactUsFormCorrectly(AcceptanceTester $I)
    {
        $I->fillField('First Name','Tom');
        $I->fillField('Surname','Smith');
        $I->fillField('Email','tom@email.com');
        $I->fillField('Contact Number','3334445555');
        $I->fillField('Job Title','Manager');
        $I->fillField('Subject','Discussion');
        $I->fillField('Message','Hi');
    } 

    public function tryToTestContactUsPageLoads(AcceptanceTester$I)
    {
        $I->see('Contact Us','h1');
    }
      
    // tests
    public function tryToTestRejectedEmailsOnContactUsForm(AcceptanceTester $I)
    {
        $I->amOnPage('/Contact-Us');
        $this->fillContactUsFormCorrectly($I);
        $rejectedEmailAddresses = array(
            "plainaddress","@domain.com","Joe Smith <email@domain.com>","email.domain.com","email@domain@domain.com","email@-domain.com","email@domain..com"," "
            );
        //check if every rejected email address is not valid
        for ($j=0;$j<count($rejectedEmailAddresses);$j++)
        {
            $I->fillField('Email',$rejectedEmailAddresses[$j]);
            $I->click('Submit Message');
            $I->dontSee('Thanks for contacting us! We will get in touch with you shortly.');
        }
    }

    public function tryToTestAcceptedEmailsOnContactUsForm(AcceptanceTester $I)
    {
        $acceptedEmailAddresses = array(
            "email@domain.com","firstname.lastname@domain.com","email@subdomain.domain.com","firstname+lastname@domain.com","email@123.123.123.123","1234567890@domain.com","email@domain-one.com","firstname-lastname@domain.com"
        );
        //check if every accepted email address is valid
        for ($j=0;$j<count($acceptedEmailAddresses);$j++)
        {
            $I->amOnPage('/Contact-Us');
            $this->fillContactUsFormCorrectly($I);
            $I->fillField('Email',$acceptedEmailAddresses[$j]);
            $I->click('Submit Message');
            $I->see('Thanks for contacting us! We will get in touch with you shortly.');
        }
    }
    public function tryToTestTextInputsOnContactUsForm(AcceptanceTester $I)
    {
        $fields = array(
            "First Name","Surname","Job Title","Subject","Message"
            );

        //check that every field cannot have whitespace as a valid input and can have 'test' as a valid input
        for ($j=0;$j<count($fields);$j++)
        {
            $I->amOnPage('/Contact-Us');
            $this->fillContactUsFormCorrectly($I);
            $I->fillField($fields[$j],"   ");
            $I->click('Submit Message');
            $I->dontSee('Thanks for contacting us! We will get in touch with you shortly.');

            $I->amOnPage('/Contact-Us');
            $this->fillContactUsFormCorrectly($I);
            $I->fillField($fields[$j],"test");
            $I->click('Submit Message');
            $I->see('Thanks for contacting us! We will get in touch with you shortly.');           
        }
    }
    public function tryToTestContactNumberInputOnContactUsForm(AcceptanceTester $I)
    {
        $I->amOnPage('/Contact-Us');
        $this->fillContactUsFormCorrectly($I);
        $I->fillField("Contact Number","12345");
        $I->click('Submit Message');
        $I->dontSee('Thanks for contacting us! We will get in touch with you shortly.');

        $I->fillField("Contact Number","7123456789");
        $I->click('Submit Message');
        $I->see('Thanks for contacting us! We will get in touch with you shortly.');    
    }
}
