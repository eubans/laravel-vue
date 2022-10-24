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

            // Start modules checking -------------------------
            // console.log(to.path, from.path);
            // console.log(['/'].includes(to.path));


            // console.log(to.path,"______",from.path);
            // console.log(store.state.auth.user_access.find(e=>e.url == to.path));
            // console.log(store.state.auth.user_access.some(e=>e.url == to.path));

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

    //Added new router limiter based on module auth.js
    // if(store.state.auth.modules.some(e=>e.url == to.path)){
    //     next(to.path);
    // }else{
    //     next({name: "dashboard"});
    // }


});
// router.beforeEach((to,from, next)=>{
    //  Added new router limiter based on module auth.js
    // console.log(from.path);
    // console.log(store.state.auth.modules.some(e=>e.url == to.path));
//     if(store.state.auth.modules.some(e=>e.url == to.path)){
//         next();
//     }else{
//         next({name: "dashboard"});
//     }

// });

router.onError(error => {
    if (/loading chunk\d* failed./i.test(error.message) && navigator.onLine) {
        windows.location.reload;
    }
}); // onError

export default router;
