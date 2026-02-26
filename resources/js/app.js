import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import WelcomeComponent from "./views/WelcomeComponent.vue";
import UserComponent from "./views/Users/UserComponent.vue";

const app = createApp({});
app.component('welcome-component', WelcomeComponent)
app.component('user-component', UserComponent)
app.mount('#app')
