<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Support\Str;

class Toast
{
    /**
     * @var string  The toast title
     */
    public $title;

    /**
     * @var string  The toast message
     */
    public $message;

    /**
     * @var string  The type of toast (success, error)
     */
    public $type;

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
     * Set the toast type to error.
     *
     * @return \Nova\Foundation\Toast
     */
    public function error()
    {
        $this->type = 'error';

        return $this->makeToast();
    }

    /**
     * Set the toast type to success.
     *
     * @return \Nova\Foundation\Toast
     */
    public function success()
    {
        $this->type = 'success';

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
            'detail' => [
                'title' => $this->title,
                'message' => $this->message,
            ],
            'type' => $this->type,
        ]);

        return $this;
    }
}
