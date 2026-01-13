import { createApp } from 'vue';
import UserShell from './UserShell.vue';
import router from './router';
import '/resources/css/inventory.css'

createApp(UserShell).use(router).mount('#userApp');