import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import AdminDashboard from './pages/admin/Dashboard'
import NotFound from './pages/NotFound'
import UserList from "./pages/admin/UserList";
import AcsLogList from "./pages/admin/AcsLogList";
import WorkerList from "./pages/admin/WorkerList";
import LockList from "./pages/admin/LockList";
import GroupList from "./pages/admin/GroupList";
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
    {
        path: '/user',
        name: 'User List',
        component: UserList,
        meta: {
            auth: true
        }
    },
    {
        path: '/acs/log',
        name: 'Log',
        component: AcsLogList,
        meta: {
            auth: true
        }
    },
    {
        path: '/acs/worker',
        name: 'Worker List',
        component: WorkerList,
        meta: {
            auth: true
        }
    },
    {
        path: '/acs/lock',
        name: 'Lock List',
        component: LockList,
        meta: {
            auth: true
        }
    },
    {
        path: '/acs/group',
        name: 'Group List',
        component: GroupList,
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
