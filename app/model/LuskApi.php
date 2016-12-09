<?php

namespace App\Model;

use Nette;
use Nette\Utils\Json;
use GuzzleHttp;


/**
 * Lusk public API
 *
 * @doc http://docs.lusk.apiary.io/
 */
class LuskApi
{
	private $endpoint;
	private $organizationId;
	private $client;

	public function __construct(array $parameters)
	{
		$this->client = new GuzzleHttp\Client();;
		$this->endpoint = $parameters['endpoint'];
		$this->organizationId = $parameters['organizationId'];
	}

	public function getOrganizationDetails()
	{
		$res = $this->client->request('GET', $this->endpoint . '/organizations/' . $this->organizationId);
		return Json::decode($res->getBody());
	}

	public function getOrganizationPositions() {
		$res = $this->client->request('GET', $this->endpoint . '/organizations/' . $this->organizationId . '/positions');
		return Json::decode($res->getBody());
	}

	public function getPrivacyPolicy() {
		$res = $this->client->request('GET', $this->endpoint . '/organizations/' . $this->organizationId . '/privacy-policy');
		return Json::decode($res->getBody());
	}

	public function getPosition($positionId) {
		$res = $this->client->request('GET', $this->endpoint . '/organizations/' . $this->organizationId . '/positions/' . $positionId);
		return Json::decode($res->getBody());
	}

	public function postCandidate($positionId, $name, $email, $coverLetter, $documents, $privacyPolicyAgreement) {
		$data = [
					[
							'name'     => 'name',
							'contents' => $name
					],
					[
							'name'     => 'email',
							'contents' => $email
					],
					[
							'name'     => 'coverLetter',
							'contents' => $coverLetter
					],
					[
							'name'     => 'privacyPolicyAgreement',
							'contents' => $privacyPolicyAgreement
					]
			];

			foreach ($documents as $i => $document) {
				$document->move(__DIR__ . '/../../tmp/cache/' . $document->name);
				$data[] = [
							'name'     => 'files[' . $i . ']',
							'contents' => fopen($document, 'r')
					];
			}

		$res = $this->client->request('POST', $this->endpoint . '/organizations/' . $this->organizationId . '/positions/' . $positionId . '/candidates', [
				'multipart' => $data
		]);

		return Json::decode($res->getBody());
	}

}
