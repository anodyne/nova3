<?php

return [
	['page_id' => 1, 'type' => 'header', 'key' => 'home.header', 'value' => "Welcome to the {% setting:sim_name %}!"],
	['page_id' => 1, 'type' => 'title', 'key' => 'home.title', 'value' => "Home"],
	['page_id' => 1, 'type' => 'message', 'key' => 'home.message', 'value' => "This is my first message. And here is a {% page:home:link %} to the homepage using the new page compiler engine!"],

	['page_id' => 2, 'type' => 'header', 'key' => 'login.header', 'value' => "Log In"],
	['page_id' => 2, 'type' => 'title', 'key' => 'login.title', 'value' => "Log In"],

	['page_id' => 4, 'type' => 'header', 'key' => 'logout.header', 'value' => "Log Out"],
	['page_id' => 4, 'type' => 'title', 'key' => 'logout.title', 'value' => "Log Out"],

	['page_id' => 5, 'type' => 'header', 'key' => 'password.remind.header', 'value' => "Send Password Reminder"],
	['page_id' => 5, 'type' => 'title', 'key' => 'password.remind.title', 'value' => "Send Password Reminder"],

	['page_id' => 7, 'type' => 'header', 'key' => 'password.reset.header', 'value' => "Reset Password"],
	['page_id' => 7, 'type' => 'title', 'key' => 'password.reset.title', 'value' => "Reset Password"],

	['page_id' => 9, 'type' => 'header', 'key' => 'admin.pages.header', 'value' => "Page Manager"],
	['page_id' => 9, 'type' => 'title', 'key' => 'admin.pages.title', 'value' => "Page Manager"],

	['page_id' => 10, 'type' => 'header', 'key' => 'admin.pages.create.header', 'value' => "Add Page"],
	['page_id' => 10, 'type' => 'title', 'key' => 'admin.pages.create.title', 'value' => "Add Page"],

	['page_id' => 12, 'type' => 'title', 'key' => 'admin.pages.edit.title', 'value' => "Edit Page"],
];
