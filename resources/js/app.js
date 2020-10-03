/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('new-transaction', require('./components/NewTransaction.vue').default);
Vue.component('new-agent-form', require('./components/NewAgentForm.vue').default);
Vue.component('new-company-form', require('./components/NewCompanyForm.vue').default);
Vue.component('new-TradeRegister-form', require('./components/NewTradeRegisterForm.vue').default);
Vue.component('new-documents-upload-form', require('./components/NewDocumentsUploadForm.vue').default);
Vue.component('Select2', require('v-select2-component').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
