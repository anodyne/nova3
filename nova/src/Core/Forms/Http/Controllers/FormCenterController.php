<?php namespace Nova\Core\Forms\Http\Controllers;

use BaseController,
	FormRepositoryInterface,
	FormDataRepositoryInterface,
	FormCenterRepositoryInterface;
use Nova\Core\Forms\Events;
use Illuminate\Http\Request;

class FormCenterController extends BaseController {

	protected $repo;
	protected $dataRepo;
	protected $formRepo;

	public function __construct(FormCenterRepositoryInterface $repo,
			FormRepositoryInterface $forms,
			FormDataRepositoryInterface $data)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->dataRepo = $data;
		$this->formRepo = $forms;
		
		$this->structureView = 'admin';
		$this->templateView = 'admin';
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
		
		$entry = $this->repo->insertRecord($form, $request->all());
		
		//event(new Events\FormViewerFormWasCreated($entry));
		
		flash()->success("Form Submitted!");
		
		return redirect()->back();
	}

	public function update(Request $request, $formKey, $id)
	{
		$form = $this->formRepo->getByKey($formKey);
		
		$this->validate($request, $this->formRepo->getValidationRules($form));
		
		$entry = $this->repo->update($id, $request->all());
		
		//event(new Events\FormViewerFormWasUpdated($entry));
		
		flash()->success("Form Updated!");
		
		return redirect()->back();
	}

}
