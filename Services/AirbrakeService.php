<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Services;

	use Airbrake\Notifier;

	class AirbrakeService {
		private $client;

		public function __construct($apiKey, $projectId, $ignoredExceptions = [], $host = null) {
			$args = [
				'projectKey' => $apiKey,
				'projectId' => $projectId,
			];

			if ($host !== null)
				$args['host'] = $host;

			$this->client = new Notifier($args);

			$this->client->addFilter(function($notice) use ($ignoredExceptions) {
				if (in_array($notice['errors'][0]['type'], $ignoredExceptions))
					return null;

				return $notice;
			});
		}

		/**
		 * @return Notifier
		 */
		public function getClient() {
			return $this->client;
		}
	}