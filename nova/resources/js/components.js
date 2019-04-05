import Vue from 'vue';
import NovaIcon from '@/Shared/Icons/NovaIcon';
import CsrfToken from '@/Shared/Forms/CsrfToken';
import FormMethod from '@/Shared/Forms/FormMethod';
import FormField from '@/Shared/Forms/FormField';
import ToggleSwitch from '@/Shared/Forms/ToggleSwitch';
import PageHeader from '@/Shared/PageHeader';

Vue.component('nova-icon', NovaIcon);
Vue.component('csrf-token', CsrfToken);
Vue.component('form-method', FormMethod);
Vue.component('form-field', FormField);
Vue.component('page-header', PageHeader);
Vue.component('toggle-switch', ToggleSwitch);
