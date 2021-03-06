<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Listener;

	use DaybreakStudios\Bundle\AirbrakeBundle\Services\AirbrakeService;
	use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

	class ShutdownListener {
		//const FATAL_ERRORS = E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR;
		const FATAL_ERRORS = 4437;

		private $airbrake;

		public function __construct(AirbrakeService $airbrake) {
			$this->airbrake = $airbrake;
		}

		public function register(FilterControllerEvent $event) {
			if (!$this->airbrake->isEnabled())
				return;

			register_shutdown_function([ $this, 'onShutdown' ]);
		}

		public function onShutdown() {
			$error = error_get_last();

			if (!$error)
				return;

			if (!($error['type'] & self::FATAL_ERRORS))
				return;

			$this->airbrake->notify(new \ErrorException($error['message'], $error['type'], $error['type'],
				$error['file'], $error['line']));
		}
	}