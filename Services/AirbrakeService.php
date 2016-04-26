<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Services;

	use Airbrake\Notifier;
	use Exception;

	class AirbrakeService {
		/** @var Notifier|null $client */
		private $client = null;

		public function enable($apiKey, $projectId, $ignoredExceptions = [], $env = null, $version = null, $host = null) {
			$args = [
				'projectKey' => $apiKey,
				'projectId' => $projectId,
			];

			if ($host !== null)
				$args['host'] = $host;

			if ($env !== null)
				$args['environment'] = $env;

			if ($version !== null)
				$args['appVersion'] = $version;

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

		/**
		 * @return bool
		 */
		public function isEnabled() {
			return $this->client !== null;
		}

		/**
		 * @param Exception $ex
		 * @return array|null
		 */
		public function notify(Exception $ex) {
			if (!$this->isEnabled())
				return null;

			$result = $this->client->notify($ex);

			if (!is_array($result))
				return null;

			return $result;
		}

		/**
		 * @param array $notice
		 * @return array|null
		 */
		public function sendNotice(array $notice) {
			if (!$this->isEnabled())
				return null;

			$result = $this->client->sendNotice($notice);

			if (!is_array($result))
				return null;

			return $result;
		}
	}