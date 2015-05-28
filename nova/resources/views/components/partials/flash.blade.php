@if (Session::has('flash.message'))
	<?php $level = Session::get('flash.level');?>
	<?php $content = Session::get('flash.message');?>
	<?php $header = Session::get('flash.header');?>
@endif

{!! alert($level, $content, $header) !!}