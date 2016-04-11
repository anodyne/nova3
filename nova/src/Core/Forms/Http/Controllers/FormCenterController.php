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

	public function index($formKey = null)
	{
		$this->view = 'admin/forms/form-center';
		$this->jsView = 'admin/forms/form-center-js';

		$this->data->forms = $this->formRepo->getFormCenterForms();

		$this->jsData->formKey = $formKey;
	}

	public function show($formKey)
	{
		$this->isAjax = true;

		$form = $this->formRepo->getByKey($formKey);

		if ( ! $form)
		{
			return alert('danger', "Form [{$formKey}] not found.");
		}
		else
		{
			$entries = $this->repo->getUserEntries($this->user, $form);

			return view(locate('page', 'admin/forms/form-center-dashboard'), compact('form', 'entries'));
		}
	}

	public function create($formKey)
	{
		$this->isAjax = true;

		$form = $this->formRepo->getByKey($formKey);

		if ( ! $form)
		{
			return alert('danger', "Form [{$formKey}] not found.");
		}
		else
		{
			return view(locate('page', 'admin/forms/form-center-create'), compact('form'));
		}
	}

	public function store(Request $request, $formKey)
	{
		$form = $this->formRepo->getByKey($formKey);
		
		$this->validate($request, $this->formRepo->getValidationRules($form));
		
		$entry = $this->repo->insert($form, $this->user, $request->all());
		
		event(new Events\FormCenterFormWasCreated($entry, $form));
		
		flash()->success("Form Submitted!");
		
		return redirect()->back();
	}

	public function edit($formKey, $id)
	{
		$this->view = 'admin/forms/form-center-edit';
		$this->jsView = 'admin/forms/form-center-edit-js';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->id = $id;
	}

	public function update(Request $request, $formKey, $id)
	{
		$form = $this->formRepo->getByKey($formKey);
		
		$this->validate($request, $this->formRepo->getValidationRules($form));
		
		$entry = $this->repo->update($id, $request->all());
		
		event(new Events\FormCenterFormWasUpdated($entry, $form));
		
		flash()->success("Form Updated!");
		
		return redirect()->back();
	}

}
