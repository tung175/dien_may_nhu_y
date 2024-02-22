import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);

import User from './user';
import Admin from './admin';

export const routes = [
    ...Admin,
    ...User,
    { path: '/404', name: '404', component: require('../components/NotFound.vue').default },
    { path: '*', redirect: '/404' },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

function loggedIn() {
    return localStorage.getItem('token') != null || sessionStorage.getItem('token') != null;
}

function isAdmin() {
    return localStorage.getItem('role') != 'user' || sessionStorage.getItem('role') != 'user';
}

router.beforeEach((to, from, next) => {
    document.title = to.meta.title ? to.meta.title : 'Điện Máy Như Ý';
    next();
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!loggedIn()) {
            next({
                path: '/admin/login',
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresRole)) {
        if (!isAdmin()) {
            next({
                path: '/admin/login',
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    //scroll to top when router changes
    window.scrollTo(0, 0)
    next()
})

export default router;