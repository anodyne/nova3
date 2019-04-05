import Vue from 'vue';
import NovaIcon from '@/Shared/Icons/NovaIcon';
import PageHeader from '@/Shared/PageHeader';

import CsrfToken from '@/Shared/Forms/CsrfToken';
import FormMethod from '@/Shared/Forms/FormMethod';
import FormField from '@/Shared/Forms/FormField';
import PasswordField from '@/Shared/Forms/PasswordField';
import ToggleSwitch from '@/Shared/Forms/ToggleSwitch';

Vue.component('nova-icon', NovaIcon);
Vue.component('page-header', PageHeader);

Vue.component('csrf-token', CsrfToken);
Vue.component('form-method', FormMethod);
Vue.component('form-field', FormField);
Vue.component('password-field', PasswordField);
Vue.component('toggle-switch', ToggleSwitch);
