import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import WelcomeComponent from "./components/WelcomeComponent.vue";
import FormComponent from "./components/Forms/FormComponent.vue";
import UsersComponent from "./components/Users/UsersComponent.vue";

const app = createApp({});
app.component('welcome-component', WelcomeComponent)
app.component('form-component', FormComponent)
app.component('users-component', UsersComponent)
app.mount('#app')
