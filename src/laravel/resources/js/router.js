import VueRouter from 'vue-router'
// Pages
import Register from './pages/auth/Register'
import Login from './pages/auth/Login'
import AdminDashboard from './pages/admin/Dashboard'
// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        redirect: { name: 'admin.dashboard' },
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // ADMIN ROUTES
    {
        path: '/admin',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        }
    },
];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});
export default router
