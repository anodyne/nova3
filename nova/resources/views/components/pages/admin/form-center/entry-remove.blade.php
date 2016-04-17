{!! Form::model($entry, ['route' => [$form->resource_destroy, $form->key, $entry->id], 'method' => 'delete']) !!}
{!! Form::close() !!}