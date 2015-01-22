@if (Session::has('flash.message'))
	<?php $level = Session::get('flash.level');?>
	<?php $content = Session::get('flash.message');?>
@endif

{!! alert($level, $content) !!}