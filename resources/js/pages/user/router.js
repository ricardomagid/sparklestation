import { createRouter, createWebHistory } from 'vue-router'
import Settings from './tabs/Settings.vue'
import Inventory from './tabs/Inventory.vue'
import Characters from './tabs/Characters.vue'

const routes = [
    {
        path: '/user',
        redirect: '/user/settings'
    },
    {
        path: '/user/settings',
        name: 'Settings',
        component: Settings,
    },
    {
        path: '/user/inventory',
        name: 'Inventory',
        component: Inventory,
    },
    {
        path: '/user/characters',
        name: 'Characters',
        component: Characters,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;