<?php

namespace Aodamuz\FormatCode;

use Illuminate\Support\ServiceProvider;
use Aodamuz\FormatCode\Commands\AllCommand;
use Aodamuz\FormatCode\Commands\FileCommand;
use Aodamuz\FormatCode\Commands\ScanCommand;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

class FormatCodeServiceProvider extends ServiceProvider {
	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot() {
		$source = realpath($raw = __DIR__.'/../config/format-code.php') ?: $raw;

		if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
			$this->publishes([$source => config_path('format-code.php')]);
		} elseif ($this->app instanceof LumenApplication) {
			$this->app->configure('format-code');
		}

		$this->mergeConfigFrom($source, 'format-code');
	}

	/**
	 * Register the package services.
	 *
	 * @return void
	 */
	public function register() {
		if ($this->app->runningInConsole()) {
			$this->commands([
				AllCommand::class,
				FileCommand::class,
				ScanCommand::class,
			]);
		}
	}
}
