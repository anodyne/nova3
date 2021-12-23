<x-form :action="route('forms.destroy', $form)" method="DELETE" id="form" :divide="false">
    Are you sure you want to delete the {{ $form->name }}?
</x-form>
