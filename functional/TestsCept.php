<?php
class ContactUsFormCest 
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/contact us']);
    }

    public function openContactUsPage(\FunctionalTester $I)
    {
        $I->see('Contact us', 'h1');    		
    }
    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            "ContactForm[@name='name']" => 'Natalia',
			"ContactForm[@name='tel']" => '+375295652395',
            "ContactForm[@name='email']" => 'Snezhnaja1@mail.ru',
            "ContactForm[@name='message']" => 'Прошу вас связаться со мной для обсуждения условий договора.',
            
        ]);
        $I->seeInfoIsSent();
        $I->dontSeeElement('#contact-form');
        $I->see('Thank you! Your request has been successfully received. 
                  One of our representatives will contact you within 24 hours.');
	}
		
    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', []);
        $I->expectTo('see validations errors');
        $I->see('Contact Us', 'h1');
        $I->see('Name');
		$I->see('Phone');
        $I->see('Email');
        $I->see('Message');
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            "ContactForm[@name='name']" => 'Natalia',
			"ContactForm[@name='tel']" => '+375295652395',
            "ContactForm[@name='email']" => 'Snezhnaja1@mailт.ru',
            "ContactForm[@name='message']" => 'Прошу вас связаться со мной для обсуждения условий договора.',
            
        ]);
        $I->expectTo('see that email address is invalid');
        $I->dontSee('Name is invalid');
		$I->dontSee('Phone is invalid');
        $I->see('Email is not a valid email address.');
        $I->dontSee('Message is invalid');    
    }

    public function submitFormWithIncorrectName(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            "ContactForm[@name='name']" => '$',
			"ContactForm[@name='tel']" => '+375295652395',
            "ContactForm[@name='email']" => 'Snezhnaja1@mail.ru',
            "ContactForm[@name='message']" => 'Прошу вас связаться со мной для обсуждения условий договора.',
            
        ]);
        $I->expectTo('see that name is invalid');
		$I->see('Name is not a valid name.');
        $I->dontSee('Phone is invalid');
		$I->dontSee('Email is invalid');
        $I->dontSee('Message is invalid');        
    }
	public function submitFormWithShortMessage(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            "ContactForm[@name='name']" => '$',
			"ContactForm[@name='tel']" => '+375295652395',
            "ContactForm[@name='email']" => 'Snezhnaja1@mail.ru',
            "ContactForm[@name='message']" => 'Прошу',
            
        ]);
        $I->expectTo('see that message is invalid');
		$I->dontSee('Name is invalid');
        $I->dontSee('Phone is invalid');
		$I->dontSee('Email is invalid');
        $I->see('Message is invalid');		
	}
	public function submitFormWithSpacesEcxeptValues(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            "ContactForm[@name='name']" => '  ',
			"ContactForm[@name='tel']" => '  ',
            "ContactForm[@name='email']" => '  ',
            "ContactForm[@name='message']" => '  ',
            
        ]);
        $I->expectTo('see that name is invalid, phone is invalid, email is invalid, message is invalid');
		$I->see('Name is invalid');
        $I->see('Phone is invalid');
		$I->see('Email is invalid');
        $I->see('Message is invalid');
	}
	public function submitFormWithLettersInPhone(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            "ContactForm[@name='name']" => 'Natalia',
			"ContactForm[@name='tel']" => 'РБ5652396',
            "ContactForm[@name='email']" => 'Snezhnaja1@mail.ru',
            "ContactForm[@name='message']" => 'Прошу вас связаться со мной для обсуждения условий договора.',
            
        ]);
        $I->expectTo('see that phone is invalid');
		$I->dontSee('Name is invalid');
        $I->see('Phone is invalid');
		$I->dontSee('Email is invalid');
        $I->dontSee('Message is invalid');
	}
}

    