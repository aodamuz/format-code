<?php

namespace Aodamuz\FormatCode\Commands;

use Aodamuz\FormatCode\FormatCode;
use Symfony\Component\Finder\Finder;
use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand {
	/**
	 * Formatter instance from container.
	 *
	 * @return \Aodamuz\FormatCode\FormatCode
	 */
	public function formatterInstance() {
		return app(FormatCode::class);
	}

	/**
	 * Scan the given directories.
	 *
	 * @param array $directories
	 *
	 * @return void
	 */
	public function scan($directories) {
		$count = 0;
		$lines = [];
		$files = [];

		foreach ($directories as $directory) {
			if (!is_dir($directory)) {
				return $this->error("The directory {$directory} does not exist.");
			}

			if (!is_readable($directory)) {
				return $this->error("The directory {$directory} cannot be read.");
			}

			if (!is_writable($directory)) {
				return $this->error("Cannot write to {$directory}.");
			}
		}

		if (!$this->confirm('Do you want to format all files in "' . implode(', ', $directories) . '"?', true))
			return;

		$filename = config('format-code.file-name', [
			'*.stub',
			'*.php'
		]);

		foreach ($directories as $directory) {
			$finder = Finder::create()->in($directory);

			foreach ($finder->files()->name($filename) as $file) {
				$files[dirname($file->getRealPath())][] = $file->getRealPath();

				$count++;
			}
		}

		$progress = $this->output->createProgressBar($count);

		$progress->start();

		foreach ($files as $directory => $unused) {
			$count = $this->formatterInstance()->run($files[$directory], $progress);

			$directory = trim(str_replace(base_path(), '', $directory), '/\\');

			$lines[$directory][] = "{$count} files formatted in:";
		}

		$progress->finish();

		$this->output->newLine(2);

		foreach ($lines as $dir => $unused) {
			foreach ($lines[$dir] as $line) {
				$this->output->writeln("<info>{$line}</info> {$dir}");
			}
		}

		$this->output->newLine();

		$this->info("Done");
	}
}
