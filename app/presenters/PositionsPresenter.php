<?php

namespace App\Presenters;

use Nette;

class PositionsPresenter extends Nette\Application\UI\Presenter
{
	/** @var \App\Model\LuskApi @inject */
	public $api;

	/** @var \App\Forms\ApplyFormFactory @inject */
	public $factory;

	private $positionId;

	/**
	 * Apply form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentApplyForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form, $values) {
			$res = $this->api->postCandidate(
				$this->positionId,
				$values->name, 
				$values->email, 
				$values->coverLetter, 
				$values->documents, 
				$values->agree
			);
			$this->flashMessage($res->message);
			$form->getPresenter()->redirect('Positions:');
		};
		return $form;
	}

	public function renderDefault()
	{
		$this->template->organization = $this->api->getOrganizationDetails();
		$this->template->positions = $this->api->getOrganizationPositions();
	}

	public function renderDetail($id)
	{
		$this->template->organization = $this->api->getOrganizationDetails();
		$this->template->position = $this->api->getPosition($id);
	}

	public function actionApply($id)
	{
		$this->positionId = $id;
		$this->template->organization = $this->api->getOrganizationDetails();
		$this->template->position = $this->api->getPosition($id);
	}

}
