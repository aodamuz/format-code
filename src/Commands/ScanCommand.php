<?php

namespace Aodamuz\FormatCode\Commands;

use Illuminate\Console\Command;
use Aodamuz\FormatCode\ParsePath;
use Aodamuz\FormatCode\FormatCode;

class ScanCommand extends Command {
	use ParsePath;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'format:scan
							{path : Relative or absolute path of directories separated by a comma.}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Format all PHP files in the given directories.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle() {
		$paths = $this->parsePath(explode(',', $this->argument('path')));

		foreach ($paths as $path) {
			if (!is_dir($path)) {
				return $this->error("The directory {$path} does not exist.");
			}

			if (!is_readable($path)) {
				$this->error("The directory {$path} cannot be read.");

				return;
			}

			if (!is_writable($path)) {
				$this->error("Cannot write to {$path}.");

				return;
			}
		}

		if (!$this->confirm("Format all files?", true))
			return;

		$count = $this->laravel->make(
			FormatCode::class
		)->scan($paths);

		$this->info("{$count} files have been successfully formatted.");
	}
}
