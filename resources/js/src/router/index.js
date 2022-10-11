import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/index.vue';
import store from '../store';
import axios from 'axios';

Vue.use(VueRouter);

// Main Routes
const routes = [
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

    //dashboard
    {
        path: '/',
        name: 'dashboard',
        component: Home,
        meta: {
            middleware: "auth"
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

    if (!store.state.auth.token && store.state.auth.authenticated) {
    }

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

            next()
        } else {
            next({ name: "login" })
        }
    }
});

router.onError(error => {
    if (/loading chunk\d* failed./i.test(error.message) && navigator.onLine) {
        windows.location.reload;
    }
}); // onError

export default router;
