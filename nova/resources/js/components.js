import Vue from 'vue';

import Panel from '@/Shared/Panel';
import Icon from '@/Shared/Icons/Icon';
import Dropdown from '@/Shared/Dropdown';
import PageHeader from '@/Shared/PageHeader';

import FormField from '@/Shared/Forms/FormField';
import CsrfToken from '@/Shared/Forms/CsrfToken';
import FormMethod from '@/Shared/Forms/FormMethod';
import ToggleSwitch from '@/Shared/Forms/ToggleSwitch';
import PasswordField from '@/Shared/Forms/PasswordField';
import StatefulButton from '@/Shared/StatefulButton';

/**
 * Global components
 */
Vue.component('icon', Icon);
Vue.component('panel', Panel);
Vue.component('dropdown', Dropdown);
Vue.component('page-header', PageHeader);

/**
 * Form components
 */
Vue.component('csrf-token', CsrfToken);
Vue.component('form-field', FormField);
Vue.component('form-method', FormMethod);
Vue.component('toggle-switch', ToggleSwitch);
Vue.component('password-field', PasswordField);
Vue.component('stateful-button', StatefulButton);
