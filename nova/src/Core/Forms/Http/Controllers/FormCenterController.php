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
		$this->dataRepo = $data;
		$this->formRepo = $forms;
		
		$this->structureView = 'admin';
		$this->templateView = 'admin';
	}

	public function index()
	{
		$this->view = 'admin/forms/form-center';
		//$this->jsView = 'admin/forms/forms-js';

		$this->data->forms = $this->formRepo->all()->filter(function ($form)
		{
			return $form->use_form_center;
		});

		$this->data->myForms = [
			'one', 'two', 'three', 'four'
		];
	}

	public function show($formKey)
	{
		# code...
	}

	public function create($formKey)
	{
		$this->view = 'admin/forms/form-viewer-create';
		$this->jsView = 'admin/forms/form-viewer-create-js';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);
	}

	public function store(Request $request, $formKey)
	{
		$form = $this->formRepo->getByKey($formKey);
		
		$this->validate($request, $this->formRepo->getValidationRules($form));
		
		$entry = $this->repo->insert($form, $this->currentUser, $request->all());
		
		event(new Events\FormCenterFormWasCreated($entry, $form));
		
		flash()->success("Form Submitted!");
		
		return redirect()->back();
	}

	public function edit($formKey, $id)
	{
		# code...
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
