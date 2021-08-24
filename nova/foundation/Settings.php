<?php

declare(strict_types=1);

namespace Domain\Settings;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use JsonSerializable;

class Settings implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    /**
     * Array of default values
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Array of settings values
     *
     * @var array
     */
    protected $settings = [];

    public function __construct($settings, $defaults = [])
    {
        $this->defaults($defaults);

        $this->fill($settings);
    }

    /**
     * create a new settings instance from a json string
     *
     * @param string $json
     *
     * @return self
     */
    public static function fromJson($json)
    {
        return new self(json_decode($json, true));
    }

    /**
     * Get a setting from the data.
     *
     * @param  string  $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->settings, $key, $default);
    }

    /**
     * Set a given setting
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function set($key, $value)
    {
        Arr::set($this->settings, $key, $value);

        return $this;
    }

    /**
     * Remove a value from settings
     *
     * @param  array|string  $keys
     *
     * @return self
     */
    public function forget(...$keys)
    {
        Arr::forget($this->settings, Arr::flatten($keys));

        return $this;
    }

    /**
     * Set a given setting, only if it is not already set
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function add($key, $value)
    {
        $this->settings = Arr::add($this->settings, $key, $value);

        return $this;
    }

    /**
     * Get all of the settings except for a specified array of keys.
     *
     * @param  array|string  $keys
     *
     * @return \Domain\Settings\Settings
     */
    public function except(...$keys)
    {
        return new self(Arr::except($this->settings, Arr::flatten($keys)));
    }

    /**
     * Get a subset of the settings.
     *
     * @param  array|string  $keys
     *
     * @return \Domain\Settings\Settings
     */
    public function only(...$keys)
    {
        return new self(Arr::only($this->settings, Arr::flatten($keys)));
    }

    /**
     * Get the raw settings array (without casting properties toArray)
     *
     * @return array
     */
    public function getRawSettings()
    {
        return $this->settings;
    }

    /**
     * Populate the settings values (merged on top of $defaults)
     *
     * @param array $settings
     *
     * @return mixed
     */
    public function fill($settings)
    {
        $this->settings = collect($this->defaults)->mergeRecursive($settings)->toArray();

        return $this;
    }

    /**
     * merge new settings on top of current settings
     *
     * @param array $settings
     *
     * @return mixed
     */
    public function merge($settings)
    {
        $this->settings = collect($this->settings)->merge($settings)->toArray();

        return $this;
    }

    /**
     * Recursively merge new settings on top of existing settings
     *
     * @param array $settings
     *
     * @return mixed
     */
    public function mergeRecursive($settings)
    {
        $this->settings = collect($this->settings)->mergeRecursive($settings)->toArray();

        return $this;
    }

    /**
     * Append a value to a specific (array) setting
     *
     * @param string $key
     * @param array $values
     *
     * @return mixed
     */
    public function append($key, $values)
    {
        $existing = $this->get($key, []);
        $appended = collect(is_array($existing) ? $existing : [ $existing ])
            ->concat($values)
            ->toArray();

        $this->set($key, $appended);

        return $this;
    }

    /**
     * Increment a numeric setting
     *
     * @param  string  $key
     * @param  int  $by
     *
     * @return $this
     */
    public function increment($key, $by = 1)
    {
        return $this->set($key, $this->get($key, 0) + $by);
    }

    /**
     * Decrement a numeric setting
     *
     * @param  string  $key
     * @param  int  $by
     *
     * @return $this
     */
    public function decrement($key, $by = 1)
    {
        return $this->set($key, $this->get($key, 0) - $by);
    }

    /**
     * Set the default values for the settings
     *  - merged _under_ the current settings
     *  - any subsequent set/fill merges on top of these defaults
     *
     * @param array $defaultSettings
     *
     * @return mixed
     */
    public function defaults($defaultSettings)
    {
        $this->defaults = $defaultSettings;

        $this->settings = collect($defaultSettings)->mergeRecursiveDistinct($this->settings)->toArray();

        return $this;
    }

    /**
     * Cast the settings to an array (recursively)
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->settings)->map(function ($item, $key) {
            return $this->get($key);
        })->toArray();
    }

    /**
     * Dynamically retrieve settings on the object.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Dynamically set settings on the object.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Determine if a setting exists on the object.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Unset a setting on the object.
     *
     * @param  string  $key
     *
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Determine if the given setting exists.
     *
     * @param  mixed  $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ! is_null($this->get($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->forget($offset);
    }

    /**
     * Convert the instance to JSON.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
