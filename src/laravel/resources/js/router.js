import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import AdminDashboard from './pages/admin/Dashboard'
import NotFound from './pages/NotFound'
// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        redirect: '/admin'
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
    {
        path: '/admin',
        name: 'dashboard',
        component: AdminDashboard,
        meta: {
            auth: true
        }
    },
    { path: '/404', component: NotFound },
    { path: '*', redirect: '/404' },
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
