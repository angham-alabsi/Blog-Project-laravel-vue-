// @ts-nocheck
require('./bootstrap');
window.Vue=require('vue');

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import router from './router'
import common from './common.js'
import jsonToHtml from './jsonToHtml.js'
import store from './store.js'
import Editor from 'vue-editor-js'


Vue.use(Editor)
Vue.mixin(common);
Vue.mixin(jsonToHtml);
Vue.use(ViewUI);

Vue.component('mainapp',require('./components/mainApp.vue').default);
//Vue.component('test',require('./components/basic/methods.vue').default);

const app=new Vue({
    el:'#app',
    router,
    store,
});
