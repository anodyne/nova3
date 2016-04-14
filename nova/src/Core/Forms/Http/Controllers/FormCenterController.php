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
		$this->view = 'admin/form-center/show';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->entries = $this->repo->getUserEntries($this->user, $form);
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
		$this->view = 'admin/form-center/edit';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->entry = $this->repo->getById($id);
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
