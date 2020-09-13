<?php

namespace Aodamuz\FormatCode;

use Illuminate\Support\ServiceProvider;
use Aodamuz\FormatCode\Commands\AllCommand;
use Aodamuz\FormatCode\Commands\FileCommand;
use Aodamuz\FormatCode\Commands\ScanCommand;

class FormatCodeServiceProvider extends ServiceProvider {
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
