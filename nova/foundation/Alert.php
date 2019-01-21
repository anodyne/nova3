<?php

namespace Nova\Foundation;

use Illuminate\Support\Str;


class Alert
{
    /**
     * The alert config.
     *
     * @var array
     */
    protected $config = [
        'position' => 'center',
        'showConfirmButton' => false,
        'timer' => 3500,
        'toast' => false,
    ];

    /**
     * The alert data.
     *
     * @var array
     */
    protected $data;

    /**
     * Config to be used by the alert.
     *
     * @param  array  $data
     * @return \Nova\Foundation\Alert
     */
    public function config($key, $value = null)
    {
        if (is_array($key)) {
            $this->config = array_merge($this->config, $key);
        } else {
            $this->config[$key] = $value;
        }

        return $this;
    }

    /**
     * Persist the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    public function persist()
    {
        $this->config('showConfirmButton', true);
        $this->config('position', 'center');
        $this->config('timer', null);
        $this->config('toast', false);

        return $this;
    }

    /**
     * Toast the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    public function toast()
    {
        $this->config('showConfirmButton', false);
        $this->config('position', 'bottom-end');
        $this->config('timer', 3500);
        $this->config('toast', true);

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

        return $this->createAlert();
    }

    /**
     * Set the alert type to info.
     *
     * @return \Nova\Foundation\Alert
     */
    public function info()
    {
        $this->with('type', 'info');

        return $this->createAlert();
    }

    /**
     * Set the alert type to question.
     *
     * @return \Nova\Foundation\Alert
     */
    public function question()
    {
        $this->with('type', 'question');

        return $this->createAlert();
    }

    /**
     * Set the alert type to success.
     *
     * @return \Nova\Foundation\Alert
     */
    public function success()
    {
        $this->with('type', 'success');

        return $this->createAlert();
    }

    /**
     * Set the alert type to warning.
     *
     * @return \Nova\Foundation\Alert
     */
    public function warning()
    {
        $this->with('type', 'warning');

        return $this->createAlert();
    }

    /**
     * Get the array of alert config options.
     *
     * @param  string  $key
     * @param  string  $default
     * @return array
     */
    public function getConfig($key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }

        return data_get($this->config, $key, $default);
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
    protected function createAlert()
    {
        session()->flash('alert', [
            'message' => $this->getData('message'),
            'title' => $this->getData('title'),
            'type' => $this->getData('type'),
            'config' => $this->getConfig(),
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

        if (Str::startsWith($method, 'toast')) {
            $methodName = Str::camel(substr($method, 5));

            return $this->toast()->{$methodName}();
        }

        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::camel(substr($method, 4)), $parameters[0]);
        }
    }
}