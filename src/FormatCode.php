<?php

namespace Aodamuz\FormatCode;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FormatCode {
	use ParsePath;

	/**
	 * Finder instance.
	 *
	 * @var \Symfony\Component\Finder\Finder
	 */
	protected $finder;

	/**
	 * Create a new FormatCode instance.
	 *
	 * @param \Symfony\Component\Finder\Finder $finder
	 *
	 * @return void
	 */
	public function __construct(Finder $finder) {
		$this->finder = $finder;
	}

	/**
	 * Format all PHP files in Laravel project.
	 *
	 * @return int
	 */
	public function laravel() {
		return $this->scan([
			base_path('app'),
			base_path('config'),
			base_path('database'),
			base_path('routes'),
			base_path('tests'),
			base_path('vendor/laravel'),
		]);
	}

	/**
	 * Scan specific directories.
	 *
	 * @param array|string $path
	 *
	 * @return int
	 */
	public function scan($path) {
		$files = $this->finder->in(
			$this->parsePath($path)
		)->exclude([
			'node_modules',
		])->files()->name(['*.stub', '*.php']);

		foreach ($files as $file) {
			$this->format($file);
		}

		return $files->count();
	}

	/**
	 * Format specific files.
	 *
	 * @param array|string $path
	 *
	 * @return int
	 */
	public function file($path) {
		$files = (array) $this->parsePath($path);

		foreach ($files as $file) {
			$this->format($file);
		}

		return count($files);
	}

	/**
	 * Format a specific file.
	 *
	 * @param string|\Symfony\Component\Finder\SplFileInfo
	 *
	 * @return mixed
	 */
	protected function format($path) {
		if ($path instanceof SplFileInfo) {
			$path = $path->getRealPath();
		}

		$code = file_get_contents($path);

		$code = str_replace("    ", "\t", $code);
		$code = str_replace("\r\n", "\n", $code);
		$code = str_replace(["\n{\n", "\n\t{\n", "\r\n{\r\n", "\r\n\t{\r\n"], " {\n", $code);
		$code = str_replace(' array()', " []", $code);

		if (preg_match('/\nuse (.*?);\n/', $code)) {
			$code = $this->sortImportsByLength($code);
		}

		return file_put_contents($path, $code);
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

			foreach ($uses as $key => $value) {
				$code = str_replace("use {$uses[$key]};", sprintf('[[[use:%d]]]', $key), $code);
			}

			foreach ($sorted as $key => $value) {
				$code = str_replace(sprintf('[[[use:%d]]]', $key), "use {$value};", $code);
			}
		}

		return $code;
	}
}
