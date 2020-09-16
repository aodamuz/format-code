<?php

namespace Aodamuz\FormatCode\Commands;

use Aodamuz\FormatCode\ParsePath;

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
		$directories = $this->parsePath(
			explode(',', $this->argument('path'))
		);

		$this->scan($directories);
	}
}
