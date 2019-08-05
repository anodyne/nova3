import Vue from 'vue';

import Dropdown from '@/Shared/Dropdown';
import PageHeader from '@/Shared/PageHeader';
import NovaIcon from '@/Shared/Icons/NovaIcon';

import FormField from '@/Shared/Forms/FormField';
import CsrfToken from '@/Shared/Forms/CsrfToken';
import FormMethod from '@/Shared/Forms/FormMethod';
import ToggleSwitch from '@/Shared/Forms/ToggleSwitch';
import PasswordField from '@/Shared/Forms/PasswordField';
import StateButton from '@/Shared/StateButton';

/**
 * Global components
 */
Vue.component('dropdown', Dropdown);
Vue.component('nova-icon', NovaIcon);
Vue.component('page-header', PageHeader);

/**
 * Form components
 */
Vue.component('csrf-token', CsrfToken);
Vue.component('form-field', FormField);
Vue.component('form-method', FormMethod);
Vue.component('toggle-switch', ToggleSwitch);
Vue.component('password-field', PasswordField);
Vue.component('state-button', StateButton);
