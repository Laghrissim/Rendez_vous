<template>
  <nav>
    <v-app-bar color="red" dark app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title class="text-uppercase">
        <span class="font-weight-light">Dentaire</span>
        <span>Express</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      
      <v-menu offset-y>
        <template v-slot:activator="{ props: menu  }">
          <v-btn text v-bind="mergeProps(menu)">
            <v-icon left>expand_more</v-icon>
            <span>Menu</span>
          </v-btn>
        </template>
        <v-list flat>
          <v-list-item v-for="link in links" :key="link.text" router :to="link.route" active-class="border">
            <v-list-item-title>{{ link.text }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-btn text  @click="logout">
        <span>Exit</span>
        <v-icon right>exit_to_app</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" dark app class="red darken-4">
      <v-row align="center" class="mt-5">
        <v-col>
          <v-avatar size="100" class="tw-ml-20">
            <img src="/img1.png" alt="" >
          </v-avatar>
          <p class="white--text subheading mt-1 text-center tw-ml-4">{{ user.name }}</p>
        </v-col>
      </v-row>
      <v-row class="mt-4 mb-4">
        <v-col>
          <Popup />
        </v-col>
      </v-row>
      <v-list flat>
        <v-list-item v-for="link in links" :key="link.text" router :to="link.route" active-class="border">
          <v-list-item-action>
            <v-icon >{{link.icon}}</v-icon>
          </v-list-item-action>
          
            <v-list-item-title class="tw-ml-15">{{ link.text }}</v-list-item-title>
         
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </nav>
</template>

<script>
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Popup from './Popup.vue'
import { mergeProps } from 'vue'
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
   data: () => ({
      drawer: true,
      links :[
          {icon: 'dashboard', text:'Accueil', route: '/'},
          {icon: 'folder', text:'Rendez-vous', route: '/projects'},
          {icon: 'person', text:'Nos Docteurs', route: '/team'}
      ]
     
    }),
    props: {
    user: {
      type: Object,
      required: true,
    },
  },
    components: {

      Popup,
  },
  methods: {
      mergeProps,
    //   logout() {
    //   axios.post('/logout').then((response) => {
        
    //   });
    // },
    },
    setup() {
    const router = useRouter();

    const logout = () => {
      axios.post('/logout').then(() => {
        router.push('/');
        setTimeout(() => {
        location.reload();
      }, 50);
      });
    };

    return {
      logout,
    };
  },
   
}
</script>
<style scoped>
.border {
  border-left: 4px solid #0ba518;
}
</style>
