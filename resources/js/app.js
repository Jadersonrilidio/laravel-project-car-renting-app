/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
/**
 * Importing and configuring vuex modules
 */

import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store(
    {
        state: {
            item: {},
            transaction: {
                status: '',
                message: '',
                errors: [],
                object: {},
            }
        }
    }
);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('brands-component', require('./components/Brands.vue').default);
Vue.component('card-component', require('./components/CardComponent.vue').default);
Vue.component('alert-component', require('./components/AlertComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('paginate-component', require('./components/PaginateComponent.vue').default);
Vue.component('breadcrumb-component', require('./components/BreadcrumbComponent.vue').default);
Vue.component('modal-component', require('./components/ModalComponent.vue').default);
Vue.component('input-container-component', require('./components/InputContainerComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('globalFormatDateTime', datetime => {
    if (!Date.parse(datetime))
        return datetime;

    datetime = datetime.split('T');

    let date = datetime[0];
    date = date.split('-');
    date = date[1] + '/' + date[2] + '/' + date[0]

    let time = datetime[1];
    time = time.split('.')[0];

    return date + ' - ' + time;
})

const app = new Vue({
    el: '#app',
    store
});
