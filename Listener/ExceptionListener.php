<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Listener;

	use DaybreakStudios\Bundle\AirbrakeBundle\Services\AirbrakeService;
	use Symfony\Component\Console\Event\ConsoleExceptionEvent;
	use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

	class ExceptionListener {
		/** @var AirbrakeService $airbrake */
		private $airbrake;

		public function __construct(AirbrakeService $airbrake) {
			$this->airbrake = $airbrake;
		}

		public function onKernelException(GetResponseForExceptionEvent $event) {
			$this->notify($event->getException());
		}

		public function onConsoleException(ConsoleExceptionEvent $event) {
			$this->notify($event->getException());
		}

		private function notify(\Exception $exception) {
			$this->airbrake->notify($exception);
		}
	}