<?php

namespace Nova\Foundation\Jobs;

use Model;
use Exception;
use Nova\Foundation\Notifications\QueuedJobFailed;

class BaseJob
{
	/**
	 * Data used for the job.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Instance of the model for the job or the primary key for look up.
	 *
	 * @var object
	 */
	protected $model;

	/**
	 * The model class.
	 *
	 * @var string
	 */
	protected $modelClass;

	/**
	 * A description of the job for failed email notifications.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Create a new instance of the job.
	 *
	 * @param  array  $data
	 * @param  mixed  $model
	 * @return void
	 */
	public function __construct(array $data, $model = null)
	{
		$this->data = $data;
		$this->model = $this->getModel($model);
	}

	/**
	 * If the job fails and it was queued, we will send an email to the admins
	 * to notify them that this particular job wasn't run or that there was
	 * an error they need to address.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function failed(Exception $exception)
	{
		if (config('queue.driver') != 'sync') {
			return new QueuedJobFailed($this->description);
		}
	}

	/**
	 * Get the model from whatever we're passed.
	 *
	 * @param  mixed  $model
	 * @return null|\Illuminate\Database\Eloquent\Model
	 */
	protected function getModel($model)
	{
		if (is_null($model)) {
			return null;
		}

		if ($model instanceof Model) {
			return $model;
		}

		return (new $this->modelClass)->find($model);
	}
}
