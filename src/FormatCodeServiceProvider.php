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
	 * Register the package services.
	 *
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom($this->configPath(), 'format-code');

		if ($this->app->runningInConsole()) {
			$this->commands([
				AllCommand::class,
				FileCommand::class,
				ScanCommand::class,
			]);
		}
	}

	/**
	 * Register the config for publishing
	 *
	 */
	public function boot() {
		if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
			$this->publishes([$this->configPath() => config_path('format-code.php')], 'format-code');
		} elseif ($this->app instanceof LumenApplication) {
			$this->app->configure('format-code');
		}
	}

	/**
	 * Set the config path
	 *
	 * @return string
	 */
	protected function configPath() {
		return __DIR__ . '/../config/format-code.php';
	}
}
