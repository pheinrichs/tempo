/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function (message) {
    window.events.$emit('flash', message);
};
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/util/Flash.vue'));
Vue.component('account-table', require('./components/account/Table.vue'));
Vue.component('list', require('./components/account/List.vue'));
Vue.component('tabs', require('./components/util/Tabs.vue'));
Vue.component('tab', require('./components/util/Tab.vue'));
Vue.component('modal', require('./components/util/Modal.vue'));
Vue.component('new-tab-modal', require('./components/account/modal/NewTabModal.vue'));
Vue.component('new-field-modal', require('./components/account/modal/NewFieldModal.vue'));
Vue.component('edit-field-modal', require('./components/account/modal/EditFieldModal.vue'));

const app = new Vue({
    el: '#app',
    data: {
        sidebar: false,
        loaded: false
    }
});