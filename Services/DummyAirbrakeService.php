<?php
	namespace DaybreakStudios\Bundle\AirbrakeBundle\Services;

	class DummyAirbrakeService extends AirbrakeService {
		public function __construct() {}

		public function getClient() {
			return null;
		}
	}