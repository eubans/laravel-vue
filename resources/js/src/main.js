require('../bootstrap');

import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

//bootstrap vue
import { BootstrapVue } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';
Vue.use(BootstrapVue);

//perfect scrollbar
import PerfectScrollbar from 'vue2-perfect-scrollbar';
Vue.use(PerfectScrollbar);

//vue-scrollactive
import VueScrollactive from 'vue-scrollactive';
Vue.use(VueScrollactive);

//vue-meta
import VueMeta from 'vue-meta';
Vue.use(VueMeta, {
    refreshOnceOnNavigation: true
});

//Sweetalert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
    confirmButtonColor: '#4361ee',
    cancelButtonColor: '#e7515a'
};
Vue.use(VueSweetalert2, options);

// Axios
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

//portal vue
import PortalVue from 'portal-vue';
Vue.use(PortalVue);

//loading
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
Vue.use(Loading, {
    // props
    color: '#1D1A27'
}, {
    // slots
})

//vue-i18n
// import i18n from './i18n';

Vue.config.productionTip = false;

//moment
import moment from 'moment';

Vue.prototype.moment = moment

// set default settings
import appSetting from './app-setting';
Vue.prototype.$appSetting = appSetting;
appSetting.init();

//global functions
import helpers from './helpers'
const plugin = {
  install () {
    Vue.helpers = helpers
    Vue.prototype.$helpers = helpers
  }
}
Vue.use(plugin)

new Vue({
    router,
    store,
    // i18n,
    render: h => h(App)
}).$mount('#app');
