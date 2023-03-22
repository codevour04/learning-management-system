import { createRouter, createWebHistory } from 'vue-router';
import DataTable from '../DataTable.vue'
import Login from '../Login.vue'
import Profile from '../Profile.vue'
import AdminPage from '../AdminPage.vue'
import RolesAndPermissions from '../RolesAndPermissionsPage.vue'
import CoursesPage from '../CoursesPage.vue'
import CustomerList from '../CustomerList.vue'

const routes = [
    {
        path: '/',
        component: Login
    },

    {
        path: '/management/login',
        component: Login
    },

    {
        path: '/management/register',
        component: Login
    },

    {
        path: '/management/home',
        component: AdminPage,
        meta: {
            permission: "view roles and permissions"
        }
    },

    {
        path: '/management/profile',
        component: Profile,
    },

    {
        path: '/management/user',
        component: DataTable
    },

    {
        path: '/management/roles-and-permissions',
        component: RolesAndPermissions
    },

    {
        path: '/management/courses',
        component: CoursesPage
    }
];

const router = new createRouter({
    history: createWebHistory(),
    routes
});

export default router;
