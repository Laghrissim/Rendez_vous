<template>
  <nav>
    <v-app-bar color="white" dark app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <router-link :to="'/'" class="tw-text-black font-bold text-decoration-none">
        <v-toolbar-title class="text-uppercase" >
          <span class="font-weight-light">Dentaire</span>
          <span>Express</span>
        </v-toolbar-title>
      </router-link>
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
      <v-menu offset-y>
        <template v-slot:activator="{ props: menu  }">
          <v-btn text v-bind="mergeProps(menu)">
            <v-icon v-if="tomorrowAppointments.length === 0 && missedAppointments.length === 0"><img src="/bell.png" alt=""></v-icon>
            <div v-else>
            <v-icon ><img src="/bell-ring.png" alt=""></v-icon><small class="tw-mr-1"><sup style="color:Tomato; font-weight: bold; font-size: 105%;" >{{ tomorrowAppointments.length +  missedAppointments.length  }}</sup></small>
            </div>
            <span>Notification</span>
          </v-btn>
        </template>
        <v-list flat >
          <v-list-item  >
            <small v-if="tomorrowAppointments.length === 0 && missedAppointments.length === 0"> Your notification shows Here</small>
            <router-link v-if="tomorrowAppointments.length > 0 || missedAppointments.length > 0 " class="avat" :to="{ name: 'projects' }">
              <v-list-item-title class="avatar" v-if="tomorrowAppointments.length > 0">
                <v-icon class="tw-inline-block">
                  <img src="/bell-badge-outline.png" alt="">
                </v-icon>
                <small class="tw-text-center">
                  <strong>{{ tomorrowAppointments.length }}</strong> appointments scheduled for tomorrow
                </small>
              </v-list-item-title>
            
            <v-list-item-title class="tw-bg-red-100  avatar" v-if="missedAppointments.length > 0"><v-icon><img src="/bell-badge-outline.png" alt=""></v-icon><small  class="tw-text-center"><strong >{{ missedAppointments.length }} </strong> appointments missed </small> </v-list-item-title>
          </router-link>
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
        <v-col class="tw-hover:opacity-25">
          <v-avatar size="100"  @click="openImagePicker" class="avatar">
          <img :src="imageUrl" alt="" class="tw-hover:opacity-25">
        </v-avatar>
        <input ref="imageInput" type="file" accept="image/*" style="display: none" @change="handleImageChange">
          <p class="white-text subheading mt-1 text-center  tw-font-bold">{{ user.name }}</p>
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
            <v-icon size="16">{{link.icon}}</v-icon>
            <v-list-item-title class="tw-ml-5" >{{ link.text }}</v-list-item-title>

          </v-list-item-action>
          
         
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </nav>
</template>

<script>
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Popup from './Popup.vue'
import {  mergeProps } from 'vue'
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
   data: () => ({
    imageUrl:'',
    appointments: [],
      tomorrowAppointments: [],
      missedAppointments: [],
      drawer: false,
      links :[
          {icon: 'dashboard', text:'Accueil', route: '/'},
          {icon: 'folder', text:'Rendez-vous', route: '/projects'},
          {icon: 'person', text:'Vos Clients', route: '/team'}
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
      openImagePicker() {
      this.$refs.imageInput.click(); // Trigger the file input when the avatar is clicked
    },
    handleImageChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.uploadImage(file);
      }
    },
    async uploadImage(file) {
      try {
        const formData = new FormData();
        formData.append('profile_picture', file);
        
        // Use axios to post the image to the server (adjust the endpoint as needed)
        const response = await axios.post('/api/upload-image', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        // Update the imageUrl to the uploaded image's URL
        this.imageUrl = response.data.url;
      } catch (error) {
        console.error('Error uploading image:', error);
      }
    },
    getTomorrowAppointments() {
      const today = new Date();

      this.tomorrowAppointments = this.appointments.filter(appointment => {
        const appointmentDate = new Date(appointment.date);
        return appointmentDate.getTime() < today.getTime() + 24 * 60 * 60 * 1000 && appointmentDate.getTime() > today.getTime() ; 
; // Compare if appointment date is tomorrow
      });
    },
    getMessedAppointments() {
      const today = new Date();

      this.missedAppointments = this.appointments.filter(appointment => {
        const appointmentDate = new Date(appointment.date);
        return appointmentDate.getTime() < today.getTime() ; 
      });
    },
    },
    setup() {
    const router = useRouter();

    const logout = () => {
      axios.post('/docteur/logout').then(() => {
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
  async mounted() {
  try {
    // Fetch appointments from the server using Axios
    axios
      .get('api/doctorAppointments')
      .then(response => {
        this.appointments = response.data;

        // Call the method to filter tomorrow's appointments
        this.getTomorrowAppointments();
        this.getMessedAppointments();
        console.log(this.tomorrowAppointments);
      })
      .catch(error => {
        console.error(error);
      });
    // Simulate an asynchronous operation to fetch the user data
    await new Promise((resolve) => setTimeout(resolve, 1000));

    console.log(this.user.profile_picture);
    if (this.user.profile_picture) {
      this.imageUrl = this.user.profile_picture;
    } else {
      this.imageUrl = '/img1.png';
    }
  } catch (error) {
    console.error('Error fetching user data:', error);
  }
},


   
}
</script>
<style scoped>
.border {
  border-left: 4px solid #0ba518;
  text-decoration: none;
}
.v-list-item {
  /* Remove text underline on hover */
  text-decoration: none;
}
.v-toolbar-title {
  text-decoration: none;

}
.avatar:hover {
    opacity: 0.5; /* Adjust the opacity value as desired */
    /* Add any other styles for the hover effect here */
  }
.avat {
  text-decoration: none;

  }
  
</style>
