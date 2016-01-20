# Installation

### Step 1: Install the Bundle
```shell
$ composer require dbstudios/airbrake-bundle
```

### Step 2: Enable the Bundle
```php
// app/AppKernel.php
public function registerBundles() {
	return array(
		// ...
		new DaybreakStudios\Bundle\AirbrakeBundle\DaybreakStudiosAirbrakeBundle(),
	);
}
```

### Step 3: Configure
While it is possible to add your API key and Project ID directly to `config.yml`, this would cause your private API key to be
published to your VCS. It is recommended that you follow the examples below and place the Project ID and API key in
`parameters.yml`.

```yml
# app/config/config.yml
daybreak_studios_airbrake:
	enabled: false
	api_key: %airbrake.api_key%
	project_id: %airbrake.project_id%
	ignored_exceptions: [] # Optional array of exceptions to be ignored by the bundle;
						   # these will NOT be sent to Airbrake
```

```yml
# app/config/config_prod.yml
daybreak_studios_airbrake:
	enabled: true
```

The above example will set up the bundle with everything you need, and will tell the bundle to only send to Airbrake if
you are in the production environment. If you would like Airbrake logging to always be enabled, you can simply set
`enabled` to true in the first YAML file in step 3.

### Step 4: Set Up Monolog Watcher (optional)
AirbrakeBundle supports watching Monolog log files for certain log levels, and sending just those log entries to Airbrake.
If you plan on using this feature, it is recommended that you follow the Symfony tutorial
[Adding a Session / Request Token](http://symfony.com/doc/current/cookbook/logging/monolog.html#adding-a-session-request-token).

To enable the log watcher, you will need to add the following to your `services.yml` file (either the global app file or the one
in your application bundle).

```yml
# services.yml
services:
	# ...
	airbrake_log_watcher:
		class: DaybreakStudios\Bundle\AirbrakeBundle\Logging\AirbrakeHandler
		arguments:
			- @daybreak_studios_airbrake.service.airbrake
			- @=constant("Monolog\\Logger::WARNING")
```

That will set up a new Monolog handler as a service. Next, you'll need to add the following to your Monolog handler stack (for
more information, please read [How to Use Monolog to Write Logs](http://symfony.com/doc/current/cookbook/logging/monolog.html),
specifically the section on using handlers).

```yml
# config.yml (or whichever config file holds your Monolog handler stack set up)
monolog:
	handlers:
		airbrake:
			type: service
			id: airbrake_log_watcher
		# ...
```
