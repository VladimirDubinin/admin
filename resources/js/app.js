import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import WelcomeComponent from "./components/WelcomeComponent.vue";

const app = createApp({});
app.component('welcome-component', WelcomeComponent)
app.mount('#app')
