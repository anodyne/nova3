<?php namespace Nova\Core\Forms\Http\Controllers;

use BaseController,
	FormRepositoryInterface,
	FormEntryRepositoryInterface;
use Nova\Core\Forms\Events;
use Illuminate\Http\Request;

class FormCenterController extends BaseController {

	protected $repo;
	protected $formRepo;

	public function __construct(FormEntryRepositoryInterface $repo,
			FormRepositoryInterface $forms)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->formRepo = $forms;
		
		$this->structureView = 'admin';
		$this->templateView = 'admin';
	}

	public function index()
	{
		$this->view = 'admin/form-center/index';

		$this->data->forms = $this->formRepo->getFormCenterForms();
	}

	public function show($formKey)
	{
		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->authorize('viewInFormCenter', $form, "You do not have permission to view this form.");

		$this->view = 'admin/form-center/show';
		$this->jsView = 'admin/form-center/show-js';

		$entries = $this->data->entries = $this->repo->getUserEntries($this->user, $form);

		$this->jsData->entryCount = $entries->count();
	}

	public function showEntry($entryId)
	{
		$this->isAjax = true;

		$entry = $this->repo->getById($entryId, ['form', 'user']);

		if ( ! $entry)
		{
			$body = alert('danger', "Form entry not found.");
		}
		else
		{
			$form = $entry->form;

			$body = ($entry->user->id == $this->user->id)
				? view(locate('page', 'admin/form-center/entry-show'), compact('form', 'entry'))
				: alert('danger', "You do not have permission to view this form entry.");
		}

		return $body;
	}

	public function store(Request $request, $formKey)
	{
		$form = $this->formRepo->getByKey($formKey);
		
		$this->validate(
			$request,
			$this->formRepo->getValidationRules($form),
			$this->validationMessages()
		);
		
		$entry = $this->repo->insert($form, $this->user, $request->all());
		
		event(new Events\FormCenterFormWasCreated($entry, $form));
		
		flash()->success("Form Entry Created!");
		
		return redirect()->back();
	}

	public function editEntry($entryId)
	{
		$this->isAjax = true;

		$entry = $this->repo->getById($entryId, ['form', 'user']);

		if ( ! $entry)
		{
			$body = alert('danger', "Form entry not found.");
		}
		else
		{
			$form = $entry->form;

			$body = (policy($form)->editFormCenterEntry($this->user, $form))
				? view(locate('page', 'admin/form-center/entry-edit'), compact('form', 'entry'))
				: alert('danger', "You do not have permission to edit this form entry.");
		}

		return $body;
	}

	public function update(Request $request, $formKey, $id)
	{
		$form = $this->formRepo->getByKey($formKey);

		$this->authorize('editFormCenterEntry', $form, "You do not have permission to edit this form entry.");
		
		$this->validate(
			$request,
			$this->formRepo->getValidationRules($form),
			$this->validationMessages()
		);
		
		$entry = $this->repo->update($id, $request->all());
		
		event(new Events\FormCenterFormWasUpdated($entry, $form));
		
		flash()->success("Form Entry Updated!");
		
		return redirect()->back();
	}

	public function remove($formKey, $entryId)
	{
		$this->isAjax = true;

		$entry = $this->repo->getById($entryId);

		if ( ! $entry)
		{
			$body = alert('danger', "Form entry not found.");
		}
		else
		{
			$form = $entry->form;

			$body = (policy($form)->removeFormCenterEntry($this->user, $form))
				? view(locate('page', 'admin/form-center/entry-remove'), compact('form', 'entry'))
				: alert('danger', "You do not have permission to remove this form entry.");
		}

		return partial('modal-content', [
			'header' => "Remove Form Entry",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(Request $request, $formKey, $id)
	{
		$form = $this->formRepo->getByKey($formKey);

		$this->authorize('removeFormCenterEntry', $form, "You do not have permission to remove this form entry.");
		
		$entry = $this->repo->delete($id);
		
		event(new Events\FormCenterFormWasDeleted($entry->id, $entry->present()->identifier, $formKey));
		
		flash()->success("Form Entry Removed!");
		
		return redirect()->back();
	}

	protected function validationMessages()
	{
		return [
			'alpha' => "This field can only contain alphabetic characters",
			'alpha_dash' => "This field can only contain alphabetic characters, dashes, or underscores",
			'alpha_num' => "This field can only container alpha-numeric characters",
			'between' => "This field must be between :min and :max",
			'email' => "This field must be a valid email address",
			'exists' => "This field must be found in the database",
			'in' => "This field must be in the following list of values: :values",
			'integer' => "This field can only contain an integer",
			'max' => "This field cannot be larger than :max",
			'min' => "This field cannot be smaller than :min",
			'not_in' => "This field must not be in the following list of values: :values",
			'numeric' => "This field can only contain numeric characters",
			'required' => "This field is required",
			'string' => "This field must be a string",
			'url' => "This field must contain a valid URL",
		];
	}

}
