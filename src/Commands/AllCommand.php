<?php

namespace Aodamuz\FormatCode\Commands;

use Illuminate\Console\Command;
use Aodamuz\FormatCode\FormatCode;

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
		if (!$this->confirm('Do you want to format all Laravel files?', true))
			return;

		$count = $this->laravel->make(
			FormatCode::class
		)->laravel();

		$this->info("{$count} files have been successfully formatted.");
	}
}
