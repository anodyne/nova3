<?php

return [

	'forms' => [

		['key' => 'application', 'name' => 'Additional Application Information', 'protected' => (int) true],
		['key' => 'character', 'name' => 'Character Information', 'protected' => (int) true],
		['key' => 'user', 'name' => 'User Information', 'protected' => (int) true],

	],

	'application' => [

		'fields' => [
			['form_id' => 1, 'order' => 0, 'type' => 'dropdown', 'label' => "Where Did You Hear About Us?", 'field_container_class' => 'col-md-4', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Choose One"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":"game-master"},{"type":"edit","value":"game-master"}]', 'values' => '[{"text":"Fleet Listing","value":"Fleet Listing"},{"text":"Internet Search","value":"Internet Search"},{"text":"Internet Ad","value":"Internet Ad"},{"text":"Recruiting Website","value":"Recruiting Website"},{"text":"Member of the Game","value":"Member of the Game"}]'],
			['form_id' => 1, 'order' => 1, 'type' => 'text-field', 'label' => "Experience", 'field_container_class' => 'col-md-3', 'help' => "How long have you been simming?", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Experience"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 1, 'order' => 2, 'type' => 'text-block', 'label' => "Other Games", 'field_container_class' => 'col-md-8', 'help' => "What other game(s) do you actively participate on? Which characters do you play?", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Other Games"},{"name":"rows","value":"5"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
		],

	],

	'character' => [

		'tabs' => [
			['form_id' => 2, 'name' => 'Basic Info', 'link_id' => 'basic-info', 'order' => 0, 'status' => Status::ACTIVE],
			['form_id' => 2, 'name' => 'Personality', 'link_id' => 'personality', 'order' => 1, 'status' => Status::ACTIVE],
			['form_id' => 2, 'name' => 'Personal History', 'link_id' => 'personal-history', 'order' => 2, 'status' => Status::ACTIVE],
		],

		'sections' => [
			['form_id' => 2, 'tab_id' => 1, 'name' => 'Physical Appearance', 'order' => 1, 'status' => Status::ACTIVE],
			['form_id' => 2, 'tab_id' => 1, 'name' => 'Family', 'order' => 2, 'status' => Status::ACTIVE],
			['form_id' => 2, 'tab_id' => 2, 'name' => 'Personality &amp; Traits', 'order' => 0, 'status' => Status::ACTIVE],
		],

		'fields' => [
			['form_id' => 2, 'tab_id' => 1, 'order' => 0, 'type' => 'dropdown', 'label' => "Gender", 'field_container_class' => 'col-md-3', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Choose One"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]', 'values' => '[{"text":"Male","value":"Male"},{"text":"Female","value":"Female"},{"text":"Transgender","value":"Transgender"},{"text":"Agender","value":"Agender"},{"text":"Androgynous","value":"Androgynous"},{"text":"Bigender","value":"Bigender"},{"text":"Intersex","value":"Intersex"},{"text":"Non-binary","value":"Non-binary"},{"text":"Pangender","value":"Pangender"},{"text":"Other","value":"Other"}]'],
			['form_id' => 2, 'tab_id' => 1, 'order' => 1, 'type' => 'text-field', 'label' => "Species", 'field_container_class' => 'col-md-3', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Species"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'tab_id' => 1, 'order' => 2, 'type' => 'text-field', 'label' => "Age", 'field_container_class' => 'col-md-2', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Age"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'section_id' => 1, 'order' => 0, 'type' => 'text-field', 'label' => "Height", 'field_container_class' => 'col-md-2', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Height"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 1, 'type' => 'text-field', 'label' => "Weight", 'field_container_class' => 'col-md-2', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Weight"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 2, 'type' => 'text-field', 'label' => "Hair Color", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Hair Color"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 3, 'type' => 'text-field', 'label' => "Eye Color", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Eye Color"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 4, 'type' => 'text-block', 'label' => "Physical Description", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Physical Description"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'section_id' => 2, 'order' => 0, 'type' => 'text-block', 'label' => "Immediate Family", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Immediate Family"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 2, 'order' => 1, 'type' => 'text-block', 'label' => "Parents", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Parents"},{"name":"rows","value":"2"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 2, 'order' => 2, 'type' => 'text-block', 'label' => "Siblings", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Siblings"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 2, 'order' => 3, 'type' => 'text-block', 'label' => "Other Family", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Other Family"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'tab_id' => 2, 'order' => 0, 'type' => 'text-block', 'label' => "Personality Overview", 'field_container_class' => 'col-md-12', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Personality Overview"},{"name":"rows","value":"6"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 0, 'type' => 'text-block', 'label' => "Strengths", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Strengths"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 1, 'type' => 'text-block', 'label' => "Weaknesses", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Weaknesses"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 2, 'type' => 'text-block', 'label' => "Ambitions", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Ambitions"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 3, 'type' => 'text-block', 'label' => "Hobbies &amp; Interests", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Hobbies &amp; Interests"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'tab_id' => 3, 'order' => 0, 'type' => 'text-block', 'label' => "Personal History", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Personal History"},{"name":"rows","value":"10"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'tab_id' => 3, 'order' => 1, 'type' => 'text-block', 'label' => "Service Record", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Service Record"},{"name":"rows","value":"10"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
		],

	],

	'user' => [

		'fields' => [
			['form_id' => 3, 'order' => 0, 'type' => 'text-field', 'label' => "Birthday", 'field_container_class' => 'col-md-3', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Birthday"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 3, 'order' => 1, 'type' => 'text-field', 'label' => "Location", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Location"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
		],

	],

];
