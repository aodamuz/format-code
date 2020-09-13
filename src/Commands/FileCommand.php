<?php

namespace Aodamuz\FormatCode\Commands;

use Illuminate\Console\Command;
use Aodamuz\FormatCode\ParsePath;
use Aodamuz\FormatCode\FormatCode;

class FileCommand extends Command {
	use ParsePath;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'format:file
							{path : Relative or absolute path of files separated by a comma.}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Format all specified PHP files.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle() {
		$paths = $this->parsePath(explode(',', $this->argument('path')));

		foreach ($paths as $path) {
			if (!is_file($path)) {
				return $this->error("The file {$path} does not exist.");
			}

			if (!is_readable($path)) {
				$this->error("The file {$path} cannot be read.");

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
		)->file($paths);

		$this->info("{$count} files have been successfully formatted.");
	}
}
