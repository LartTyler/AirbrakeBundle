<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Listener;

	use Airbrake\Notifier;
	use DaybreakStudios\Bundle\AirbrakeBundle\Services\AirbrakeService;
	use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

	class ExceptionListener {
		/** @var Notifier $airbrake */
		private $airbrake;

		public function __construct(AirbrakeService $service) {
			$this->airbrake = $service->getClient();
		}

		public function onKernelException(GetResponseForExceptionEvent $event) {
			$this->airbrake->notify($event->getException());
		}
	}