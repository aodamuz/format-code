<?php

namespace Aodamuz\FormatCode\Commands;

use Aodamuz\FormatCode\ParsePath;

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
		$files = $this->parsePath(explode(',', $this->argument('path')));

		foreach ($files as $file) {
			if (!is_file($file)) {
				return $this->error("The file {$file} does not exist.");
			}

			if (!is_readable($file)) {
				$this->error("The file {$file} cannot be read.");

				return;
			}

			if (!is_writable($file)) {
				$this->error("Cannot write to {$file}.");

				return;
			}
		}

		if (!$this->confirm("Format all files?", true))
			return;

		$count = $this->formatterInstance()->run($files);

		$this->info("{$count} files have been successfully formatted.");
	}
}
