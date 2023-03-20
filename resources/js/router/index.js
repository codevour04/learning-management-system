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
        path: '/login',
        component: Login
    },

    {
        path: '/register',
        component: Login
    },

    {
        path: '/home',
        component: AdminPage,
        meta: {
            permission: "view roles and permissions"
        }
    },

    {
        path: '/profile',
        component: CustomerList,
    },

    {
        path: '/user-management',
        component: DataTable
    },

    {
        path: '/roles-and-permissions',
        component: RolesAndPermissions
    },

    {
        path: '/courses',
        component: CoursesPage
    }
];

const router = new createRouter({
    history: createWebHistory(),
    routes
});

export default router;
