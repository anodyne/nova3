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
     * Data to be used by the toast.
     *
     * @param  array  $data
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

        return $this->makeToast();
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
                'timeout' => 3000
            ]
        ]);

        return $this;
    }

    /**
     * Dynamically bind parameters to the toast.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Nova\Foundation\Toast
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