<?php

namespace Nova\Foundation;

use Illuminate\Support\Str;

class Alert
{
    public $message;
    public $type;
    public $position = 'is-bottom';
    public $toast;

    /**
     * Set the position of the alert.
     *
     * @param  string  $value
     * @return \Nova\Foundation\Alert
     */
    public function position($value)
    {
        $this->position = "is-{$value}";

        return $this;
    }

    /**
     * Toast the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    public function toast()
    {
        $this->toast = true;

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
        $this->{$key} = $value;

        return $this;
    }

    /**
     * Set the alert type to dark.
     *
     * @return \Nova\Foundation\Alert
     */
    public function dark()
    {
        $this->type = 'is-dark';

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
     * Fire the alert.
     *
     * @return \Nova\Foundation\Alert
     */
    protected function createAlert()
    {
        $flashKey = ($this->toast)
            ? 'nova.notices.toast'
            : 'nova.notices.snackbar';

        session()->flash($flashKey, [
            'message' => $this->message,
            'type' => $this->type,
            'position' => $this->position,
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
        if (Str::startsWith($method, 'toast')) {
            $methodName = Str::camel(substr($method, 5));

            return $this->toast()->{$methodName}();
        }

        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::camel(substr($method, 4)), $parameters[0]);
        }

        if (Str::startsWith($method, 'at')) {
            return $this->position(Str::slug(Str::snake(substr($method, 2))));
        }
    }
}