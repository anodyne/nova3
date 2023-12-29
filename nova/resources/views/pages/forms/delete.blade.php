<x-form :action="route('forms.destroy', $form)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $form->name }}?
</x-form>
