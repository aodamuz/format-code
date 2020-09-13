<?php

namespace Aodamuz\FormatCode;

trait ParsePath {
	/**
	 * Make sure the directory or file exists and is an absolute path.
	 *
	 * @param string|array $path
	 *
	 * @return mixed
	 */
	protected function parsePath($path) {
		if (is_array($path)) {
			$array = [];

			foreach ($path as $dir) {
				$array[] = $this->parsePath($dir);
			}

			return $array;
		}

		if (file_exists($path = trim($path))) {
			return $path;
		}

		if (file_exists($path = base_path($path))) {
			return $path;
		}
	}
}
