<?php

namespace Nova\Foundation\Sanitizers;

trait SanitizesAndFormats
{
	/**
	 * Sanitizes and formats the request before validation.
	 *
	 * @return array
	 */
	abstract public function sanitizeAndFormat();

	/**
	 * Perform the sanitization and format of the request data before validation.
	 *
	 * @return void
	 */
	public function performSanitizationAndFormat()
	{
		$this->memrge($this->getSanitizationAndFormatData());
	}

	/**
	 * Execute the sanitization and format methods and return the data.
	 *
	 * @return array
	 */
	protected function getSanitizationAndFormatData()
	{
		$data = collect($this->sanitizeAndFormat())
			->mapWithKeys(function ($action, $field) {
				$value = $this->{$field};

				if (is_callable($action)) {
					return [$field => $action($value)];
				}

				return [$field => collect($action)->reduce(function ($content, $action) {
					if (class_exists($action)) {
						return (new $action)->handle($content);
					}

					return $action($content);
				}, $value)];
			});

		return array_filter($data->toArray());
	}
}
