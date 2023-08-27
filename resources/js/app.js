
//tailwind
import 'tailwindcss/tailwind.css';
//vue
import { createApp } from 'vue';
//vuetify
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import 'vuetify/dist/vuetify.css';
import { aliases, md } from 'vuetify/iconsets/md'

import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import * as labsComponents from 'vuetify/labs/components'
import { VuetifyDateAdapter } from 'vuetify/labs/date/adapters/vuetify'


//vue-router
import { createRouter, createWebHistory } from 'vue-router';
//vue Calendar
import VCalendar from 'v-calendar';
import 'v-calendar/style.css';



const vuetify = createVuetify({
  components: { ...components },
  directives: { ...directives },
  icons: {
    defaultSet: 'md',
    aliases,
    sets: {
      md,
    },
    date: {
      adapter: VuetifyDateAdapter,
    },
  },
  

 
})




/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});


// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

import Login from './components/Login.vue';
app.component('login', Login);

import Register from './components/Register.vue';
app.component('register', Register);

import ClientApp from './components/ClientApp.vue';
app.component('client', ClientApp);

import Dashboard from './views/Dashboard.vue';
// app.component('dashboard', Dashboard);

import Projects from './views/Projects.vue';
app.component('projects', Projects);

import Team from './views/Team.vue';
// app.component('ream', Team);

import DoctorDashboard from './views/DoctorDashboard.vue';
// app.component('navbar', Navbar);

import Clients from './views/Clients.vue';
import Doctor from './components/LoginDocteur.vue';
import First from './components/First.vue';
import DoctorApointment from './views/DoctorApointment.vue';
// app.component('footer', Footer);

// import Popup from './components/Popup.vue';
// app.component('popup', Popup);




//rooter
const routes = [
    {
      path: '/',
      name: 'dashboard',
      components: {
        default: Dashboard,
        client: Dashboard, 
        doctor: DoctorDashboard, // Named view for the doctor dashboard
        first: First, // Named view for the doctor dashboard
      },
    },
  
    {
      path: '/projects',
      name: 'projects',
      components: {
        default: Projects,
        client: Projects,// Default view
        doctor: DoctorApointment , // Named view for the doctor dashboard
      },
    },
    {
      path: '/team',
      name: 'team',
      components: {
        default: Team, // Default view
        client: Team, // Default view
        doctor: Clients, // Named view for the doctor dashboard
      },
    },
   
    {
      path: '/doctor',
      name: 'doctor',
      components: {
        default: Doctor,
        first: Doctor, // Default view
         // Named view for the doctor dashboard
      },
    },
    {
      path: '/client',
      name: 'client',
      components: {
        default: Dashboard,
        first: Login, // Default view
        // Named view for the doctor dashboard
      },
    },
  ]
  
  
  const router = createRouter({
    history: createWebHistory(),
    routes
  })


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

  
app.use(vuetify)
app.use(router)
app.use(VCalendar, {})
app.mount('#app');