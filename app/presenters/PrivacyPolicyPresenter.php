<?php

namespace App\Presenters;

use Nette;


class PrivacyPolicyPresenter extends Nette\Application\UI\Presenter
{
	/** @var \App\Model\LuskApi @inject */
	public $api;

	public function renderDefault()
	{
		$this->template->organization = $this->api->getOrganizationDetails();
		$this->template->privacyPolicy = $this->api->getPrivacyPolicy();
	}

}
