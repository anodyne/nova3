<?php

return [

	'forms' => [

		['key' => 'application', 'name' => 'Additional Application Information', 'protected' => (int) true],
		['key' => 'character', 'name' => 'Character Information', 'protected' => (int) true],
		['key' => 'user', 'name' => 'User Information', 'protected' => (int) true],

	],

	'application' => [],

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
			['form_id' => 2, 'tab_id' => 1, 'order' => 0, 'type' => 'select', 'label' => "Gender", 'field_container_class' => 'col-md-3', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Choose One"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]', 'values' => '[{"text":"Male","value":"Male"},{"text":"Female","value":"Female"},{"text":"Hermaphrodite","value":"Hermaphrodite"},{"text":"Neuter","value":"Neuter"}]'],
			['form_id' => 2, 'tab_id' => 1, 'order' => 1, 'type' => 'text', 'label' => "Species", 'field_container_class' => 'col-md-3', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Species"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'tab_id' => 1, 'order' => 2, 'type' => 'text', 'label' => "Age", 'field_container_class' => 'col-md-2', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Age"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'section_id' => 1, 'order' => 0, 'type' => 'text', 'label' => "Height", 'field_container_class' => 'col-md-2', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Height"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 1, 'type' => 'text', 'label' => "Weight", 'field_container_class' => 'col-md-2', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Weight"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 2, 'type' => 'text', 'label' => "Hair Color", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Hair Color"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 3, 'type' => 'text', 'label' => "Eye Color", 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Eye Color"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 1, 'order' => 4, 'type' => 'textarea', 'label' => "Physical Description", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Physical Description"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'section_id' => 2, 'order' => 0, 'type' => 'textarea', 'label' => "Immediate Family", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Immediate Family"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 2, 'order' => 1, 'type' => 'textarea', 'label' => "Parents", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Parents"},{"name":"rows","value":"2"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 2, 'order' => 2, 'type' => 'textarea', 'label' => "Siblings", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Siblings"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 2, 'order' => 3, 'type' => 'textarea', 'label' => "Other Family", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Other Family"},{"name":"rows","value":"4"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'tab_id' => 2, 'order' => 0, 'type' => 'textarea', 'label' => "Personality Overview", 'field_container_class' => 'col-md-12', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Personality Overview"},{"name":"rows","value":"6"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 0, 'type' => 'textarea', 'label' => "Strengths", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Strengths"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 1, 'type' => 'textarea', 'label' => "Weaknesses", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Weaknesses"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 2, 'type' => 'textarea', 'label' => "Ambitions", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Ambitions"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'section_id' => 3, 'order' => 3, 'type' => 'textarea', 'label' => "Hobbies &amp; Interests", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Hobbies &amp; Interests"},{"name":"rows","value":"3"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],

			['form_id' => 2, 'tab_id' => 3, 'order' => 0, 'type' => 'textarea', 'label' => "Personal History", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Personal History"},{"name":"rows","value":"10"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
			['form_id' => 2, 'tab_id' => 3, 'order' => 1, 'type' => 'textarea', 'label' => "Service Record", 'field_container_class' => 'col-md-8', 'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":"Service Record"},{"name":"rows","value":"10"}]', 'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]'],
		],

	],

	'user' => [],

];
