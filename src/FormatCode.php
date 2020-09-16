<?php

namespace Aodamuz\FormatCode;

use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class FormatCode {
	/**
	 * Run format.
	 *
	 * @param mixed $files
	 * @param mixed $progressBar
	 *
	 * @return int
	 */
	public function run($files, $progressBar = null) {
		$count = 0;

		foreach ($files as $file) {
			$count += $this->format($file);

			if (!is_null($progressBar)) {
				$progressBar->advance();
			}
		}

		return $count;
	}

	/**
	 * Format a specific file.
	 *
	 * @param string|\Symfony\Component\Finder\SplFileInfo
	 *
	 * @return int
	 */
	protected function format($path) {
		if ($path instanceof SplFileInfo)
			$path = $path->getRealPath();

		if (!Str::contains(file($path)[0], '<?php'))
			return;

		$code = file_get_contents($path);

		$code = str_replace(str_repeat(" ", 4), "\t", $code);
		$code = str_replace("\r\n", "\n", $code);

		$code = str_replace(["\n{\n", "\n\t{\n", "\r\n{\r\n", "\r\n\t{\r\n"], " {\n", $code);

		if (preg_match('/\nuse (.*?);\n/', $code))
			$code = $this->sortImportsByLength($code);

		return (bool) file_put_contents($path, $code) ? 1 : 0;
	}

	/**
	 * Sort class imports in order of length.
	 *
	 * @param string $code
	 *
	 * @return string
	 */
	protected function sortImportsByLength(string $code) {
		if (preg_match_all('/\nuse (.*?);/', $code, $matches)) {
			$sorted = $uses = $matches[1];

			usort($sorted, function($a, $b) {
				return strlen($a) - strlen($b);
			});

			foreach ($uses as $key => $value)
				$code = str_replace("use {$uses[$key]};", sprintf('[[[use:%d]]]', $key), $code);

			foreach ($sorted as $key => $value)
				$code = str_replace(sprintf('[[[use:%d]]]', $key), "use {$value};", $code);
		}

		return $code;
	}
}
