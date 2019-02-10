<?php

namespace Nova\Foundation;

use Illuminate\Support\Str;

class Alert
{
    public $message;
    public $type;
    public $actionText;

    /**
     * Data to be used by the alert.
     *
     * @param  array  $data
     * @return \Nova\Foundation\Alert
     */
    public function with($key, $value = null)
    {
        $this->{$key} = $value;

        return $this;
    }

    /**
     * Create an alert.
     *
     * @return \Nova\Foundation\Alert
     */
    public function make()
    {
        return $this->createAlert();
    }

    /**
     * Set the alert type to error.
     *
     * @return \Nova\Foundation\Alert
     */
    public function error()
    {
        $this->type = 'is-danger';

        return $this->createAlert();
    }

    /**
     * Set the alert type to success.
     *
     * @return \Nova\Foundation\Alert
     */
    public function success()
    {
        $this->type = 'is-success';

        return $this->createAlert();
    }

    /**
     * Create the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    protected function createAlert()
    {
        session()->flash('nova.alert', [
            'message' => $this->message,
            'type' => $this->type,
            'actionText' => $this->actionText,
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
        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::camel(substr($method, 4)), $parameters[0]);
        }
    }
}