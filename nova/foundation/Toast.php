<?php

namespace Nova\Foundation;

use Illuminate\Support\Str;

class Toast
{
    /**
     * @var string  The toast message
     */
    public $message;

    /**
     * @var string  The type of toast (success, error, make)
     */
    public $type;

    /**
     * @var string  The link for an actionable toast
     */
    public $actionLink;

    /**
     * @var string  The text for the button of an actionable toast
     */
    public $actionText;

    /**
     * @var int  The duration of the toast
     */
    public $duration = 3000;

    /**
     * Data to be used by the toast.
     *
     * @param  array  $data
     * @param mixed $key
     * @param null|mixed $value
     *
     * @return \Nova\Foundation\Toast
     */
    public function with($key, $value = null)
    {
        $this->{$key} = $value;

        return $this;
    }

    /**
     * Create a toast.
     *
     * @return \Nova\Foundation\Toast
     */
    public function make()
    {
        $this->duration = 3000;

        return $this->makeToast();
    }

    /**
     * Set the toast type to error.
     *
     * @return \Nova\Foundation\Toast
     */
    public function error()
    {
        $this->type = 'is-danger';
        $this->duration = 6000;

        return $this->makeToast();
    }

    /**
     * Set the toast type to success.
     *
     * @return \Nova\Foundation\Toast
     */
    public function success()
    {
        $this->type = 'is-success';
        $this->duration = 3000;

        return $this->makeToast();
    }

    /**
     * Dynamically bind parameters to the toast.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return \Nova\Foundation\Toast
     *
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::camel(substr($method, 4)), $parameters[0]);
        }
    }

    /**
     * Create the toast.
     *
     * @return \Nova\Foundation\Toast
     */
    protected function makeToast()
    {
        session()->flash('nova.toast', [
            'message' => $this->message,
            'type' => $this->type,
            'actionFunction' => $this->actionLink,
            'actionText' => $this->actionText,
            'config' => [
                'timeout' => $this->duration,
            ],
        ]);

        return $this;
    }
}
