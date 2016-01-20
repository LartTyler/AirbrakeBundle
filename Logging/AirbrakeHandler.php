<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Logging;

	use DaybreakStudios\Bundle\AirbrakeBundle\Exception\LoggerException;
	use DaybreakStudios\Bundle\AirbrakeBundle\Services\AirbrakeService;
	use Monolog\Handler\AbstractProcessingHandler;
	use Symfony\Bridge\Monolog\Logger;

	class AirbrakeHandler extends AbstractProcessingHandler {
		private $airbrake;

		public function __construct(AirbrakeService $airbrake, $level = Logger::DEBUG, $bubble = true) {
			parent::__construct($level, $bubble);

			$this->airbrake = $airbrake;
		}

		protected function write(array $record) {
			$this->airbrake->notify(new LoggerException($record['formatted']));
		}
	}