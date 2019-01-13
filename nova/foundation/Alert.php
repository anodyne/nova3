<?php

namespace Nova\Foundation;

use Illuminate\Support\Str;


class Alert
{
    /**
     * The alert data.
     *
     * @var array
     */
    protected $data;

    /**
     * Persist the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    public function persist()
    {
        $this->with('persist', true);

        return $this;
    }

    /**
     * Data to be used by the alert.
     *
     * @param  array  $data
     * @return \Nova\Foundation\Alert
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Set the alert type to error.
     *
     * @return \Nova\Foundation\Alert
     */
    public function error()
    {
        $this->with('type', 'error');

        return $this->fireAlert();
    }

    /**
     * Set the alert type to info.
     *
     * @return \Nova\Foundation\Alert
     */
    public function info()
    {
        $this->with('type', 'info');

        return $this->fireAlert();
    }

    /**
     * Set the alert type to success.
     *
     * @return \Nova\Foundation\Alert
     */
    public function success()
    {
        $this->with('type', 'success');

        return $this->fireAlert();
    }

    /**
     * Set the alert type to warning.
     *
     * @return \Nova\Foundation\Alert
     */
    public function warning()
    {
        $this->with('type', 'warning');

        return $this->fireAlert();
    }

    /**
     * Get the array of alert data.
     *
     * @param  string  $key
     * @param  string  $default
     * @return array
     */
    public function getData($key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }

        return data_get($this->data, $key, $default);
    }

    /**
     * Fire the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    protected function fireAlert()
    {
        session()->flash('alert', [
            'message' => $this->getData('message'),
            'title' => $this->getData('title'),
            'type' => $this->getData('type'),
        ]);

        return $this;
    }

    /**
     * Dynamically bind parameters to the alert.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Nova\Foundation\Alert
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'persist')) {
            $methodName = Str::camel(substr($method, 7));

            return $this->persist()->{$methodName}();
        }

        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::camel(substr($method, 4)), $parameters[0]);
        }
    }
}