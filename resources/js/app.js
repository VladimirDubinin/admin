import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import WelcomeComponent from "./views/WelcomeComponent.vue";
import UsersComponent from "./views/Users/UsersComponent.vue";

const app = createApp({});
app.component('welcome-component', WelcomeComponent)
app.component('users-component', UsersComponent)
app.mount('#app')
