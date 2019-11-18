require('./bootstrap');

import Vue from 'vue';

import swalPlugin from './utilities/VueSweetalert2';
import VueProgressBar from 'vue-progressbar';

import { Form, HasError, AlertError, AlertErrors, AlertSuccess } from 'vform';

import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import StoreData from './store';
import MainApp from './components/MainApp.vue';
import {initialize} from './helpers/general';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueProgressBar, {
	color: 'rgb(143, 255, 199)',
  	failedColor: 'red',
  	height: '3px'
});

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

window.Fire =  new Vue();

const store = new Vuex.Store(StoreData);

const router = new VueRouter({
	routes,
	mode:'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
