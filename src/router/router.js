import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue'
import MainPage from '../components/admin/Main-Page/main-page.vue'
import RolePermissionsView from '../components/admin/roleAndPermissions/roleAndPermissions.vue'
import UsersCrud from '../components/admin/Users/CrudUsersView.vue'

const routes=[
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/mainpage',
        name: 'mainpage',
        component: MainPage
    },
    {
        path: '/roleAndPermissions',
        name: 'roleAndPermissions',
        component: RolePermissionsView
    },
    
    {
        path: '/users',
        name: 'users',
        component: UsersCrud
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes
  })
  export default router