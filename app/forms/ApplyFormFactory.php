<?php

namespace App\Forms;

use Nette,
	Nette\Utils\Html,
	Nette\Application\UI\Form;


class ApplyFormFactory extends Nette\Object
{
	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addText('name', 'Name')
			->setAttribute('placeholder', 'Eg John Smith')
			->setRequired('Please enter your name.');

		$form->addText('email', 'Email')
			->setAttribute('placeholder', 'Eg johnsmith@example.com')
		    ->setRequired('Please enter your email.')
		    ->addRule(Form::EMAIL, 'Please enter valid email.');

	    $form->addTextArea('coverLetter', 'Cover letter')
	    	->setAttribute('placeholder', 'Cover letter should be short and concise.')
		    ->setRequired('Please enter your email.');

		$form->addMultiUpload('documents', 'Documents');

		$form->addCheckbox('agree')
			->setRequired('You have to agree with the Privacy Policy.');

		$form->addSubmit('send', 'Apply');

		return $form;
	}

}
