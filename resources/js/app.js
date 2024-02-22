/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import router from './routes';
import Vue from 'vue';
import App from './App.vue';

import VueAxios from 'vue-axios';
import axios from 'axios';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2';
import excel from 'vue-excel-export';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueBreadcrumbs from 'vue-2-breadcrumbs';
import CKEditor from '@ckeditor/ckeditor5-vue2';
import StarRating from 'vue-star-rating';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
import VueTreeNavigation from 'vue-tree-navigation';

Vue.use(VueTreeNavigation);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(VueSweetalert2);
Vue.use(excel);
Vue.use(VueBreadcrumbs, {
    template:
        '<section class=content-header>\n' +
        '    <div class="container-fluid">\n' +
        '        <div class="row mb-2">\n' +
        '            <div class="col-sm-6" v-if="$breadcrumbs.length">\n' +
        '                <h1 class="m-0" v-for="(crumb, key) in $breadcrumbs" v-if="crumb.meta.breadcrumb && key == $breadcrumbs.length-1" :key="key" >{{getBreadcrumb(crumb.meta.breadcrumb)}}</h1>\n' +
        '            </div>\n' +
        '            <div v-if="$breadcrumbs.length" class="col-sm-6">\n' +
        '                <ol class="breadcrumb float-sm-right" v-if="$breadcrumbs.length>=3">\n' +
        '                    <li v-for="(crumb, key) in $breadcrumbs" v-if="crumb.meta.breadcrumb && key >= 1" :key="key" class="breadcrumb-item">\n' +
        '                        <router-link :to="{ path: getPath(crumb) }">{{ getBreadcrumb(crumb.meta.breadcrumb) }}</router-link>' +
        '                    </li>\n' +
        '                </ol>\n' +
        '                <ol class="breadcrumb float-sm-right" v-else>\n' +
        '                    <li v-for="(crumb, key) in $breadcrumbs" v-if="crumb.meta.breadcrumb" :key="key" class="breadcrumb-item">\n' +
        '                        <router-link :to="{ path: getPath(crumb) }">{{ getBreadcrumb(crumb.meta.breadcrumb) }}</router-link>' +
        '                    </li>\n' +
        '                </ol>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</section>'
})
Vue.use( CKEditor );

Vue.component('star-rating', StarRating);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    render: h => h(App),
}).$mount('#app');
