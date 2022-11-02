import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/index.vue';
import store from '../store';
import axios from 'axios';

Vue.use(VueRouter);

// Main Routes
const routes = [
    // excempted public urls
    {
        path: '/api/reset-password/:token',
        name: 'api-reset-password',
        meta: {
            middleware: "replaced-guest",
            excemptedModuleChecking: true,
            urlReplacement: {
                realUrl: 'reset-password',
                params: [{
                    paramName: 'token',
                    paramPlacement: 3
                }]
            }
        }
    },
    // login
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/auth/login.vue'),
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../views/auth/register.vue'),
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: () => import('../views/auth/forgot-password.vue'),
        meta: {
            middleware: "guest",
            title: `Forgot Password`
        }
    },
    {
        path: '/reset-password/:token',
        name: 'reset-password',
        component: () => import('../views/auth/forgot-password.vue'),
        meta: {
            middleware: "guest",
            title: `Reset Password`
        }
    },

    //dashboard
    {
        path: '/',
        name: 'dashboard',
        component: Home,
        meta: {
            middleware: "auth",
            excemptedModuleChecking: true
        }
    },

    //settings
    {
        path: '/settings/users',
        name: 'users',
        component: () => import('../views/settings/users.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        path: '/settings/users/roles',
        name: 'user-roles',
        component: () => import('../views/settings/user-roles.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        path: '/settings/users/types',
        name: 'user-types',
        component: () => import('../views/settings/user-types.vue'),
        meta: {
            middleware: "auth"
        }
    },

    {
        // Claims
        path: '/claims',
        name: 'claims',
        component: () => import('../views/pages/claims.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        // Verification/Pending
        path: '/verification/pending',
        name: 'pending',
        component: () => import('../views/verification/pending.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        // Verification/Approved
        path: '/verification/approved',
        name: 'approved',
        component: () => import('../views/verification/approved.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        // Verification/Declined
        path: '/verification/declined',
        name: 'declined',
        component: () => import('../views/verification/declined.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        // Help
        path: '/help',
        name: 'help',
        component: () => import('../views/pages/help.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        // Portfolio
        path: '/portfolio',
        name: 'portfolio',
        component: () => import('../views/pages/portfolio.vue'),
        meta: {
            middleware: "auth"
        }
    },
    {
        // Payment
        path: '/payment',
        name: 'payment',
        component: () => import('../views/pages/payment.vue'),
        meta: {
            middleware: "auth"
        }
    },


    //global
    {
        path: '/pages/coming-soon',
        name: 'coming-soon',
        component: () => import('../views/pages/coming-soon.vue'),
        meta: {
            middleware: "guest"
        }
    },

];

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    }
});


router.beforeEach((to, from, next) => {
    if (to.meta && to.meta.middleware && to.meta.middleware == 'guest') {
        store.commit('setLayout', 'auth');
    } else {
        store.commit('setLayout', 'app');
    }
    next(true);
});

router.beforeEach((to, from, next) => {
    // setting up Sanctum Token globally
    axios.defaults.headers.common['Authorization'] = `Bearer ` + store.state.auth.token

    // if the url is for replacement
    if(to.meta.urlReplacement){
        const parsedPathname = window.location.pathname.split('/');
        const parsedQuery = Object.fromEntries(new URLSearchParams(window.location.search).entries());

        let routerObj = {
            name: to.meta.urlReplacement.realUrl,
            query: parsedQuery
        }

        if(to.meta.urlReplacement.params){
            let routerParamObj = {}
            to.meta.urlReplacement.params.forEach(function (params) {
                routerParamObj[params.paramName] = parsedPathname[params.paramPlacement]
            });
            routerObj.params = routerParamObj
        }

        if(to.meta.middleware == 'replaced-guest'){
            store.state.auth.authenticated = false;
            store.state.auth.token = null;
        }

        router.push(routerObj);
    }else{
        // check if user is authenticated
        if (to.meta.middleware == "guest") {
            if(store.state.auth.authenticated){
                next({name:"dashboard"})
            }
            next()
        } else {
            if (store.state.auth.authenticated) {
                // checking if user is login then redirecting to login page
                axios.get('/api/user').catch(() => {
                    store.state.auth.authenticated = false;
                    store.state.auth.token = null;
                    router.push({ name: "login" })
                })
                // checking if module is allowed to access
                if(!to.meta.excemptedModuleChecking){
                    if(!store.state.auth.user_access.some(e=>e.url == to.path)){
                        next({name: "dashboard"});
                    }
                }
                next();
                //end--------------------------------------
            } else {
                next({ name: "login" })
            }
        }
    }
});


router.onError(error => {
    if (/loading chunk\d* failed./i.test(error.message) && navigator.onLine) {
        windows.location.reload;
    }
}); // onError

export default router;
