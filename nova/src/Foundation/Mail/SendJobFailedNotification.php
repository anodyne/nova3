<?php

namespace Nova\Foundation\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendJobFailedNotification extends Mailable
{
	use Queueable, SerializesModels;

	public $jobType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobType)
    {
        $this->jobType = $jobType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
