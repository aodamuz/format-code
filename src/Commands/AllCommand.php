<?php

namespace Aodamuz\FormatCode\Commands;

class AllCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'format:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Format all files within the Laravel project.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle() {
		$directories = config('format-code.laravel', [
			'app',
			'config',
			'database',
			'routes',
			'tests',
			'vendor/laravel',
		]);

		$this->scan($directories);
	}
}
