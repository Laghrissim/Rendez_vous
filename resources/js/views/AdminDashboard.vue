<template>
  <div class="team">
    <v-container>
      <v-row>
          <hr class="section-divider" />
          <v-icon size="20">dashboard</v-icon>
          <h6 class="black-text">Dashboard</h6>
        </v-row>
      <v-row>
        <v-col cols="6" xs="12" md="6" lg="3" >
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="#03A9F4" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>person</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Clients</div>
              <v-list-item-title class="text-h5  text-right">{{ counts.clientCount }}</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">assignment_ind</v-icon>
              <div class="text-overline">inscrit</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="6" xs="12" md="6" lg="3">
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="#FFC107" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>work</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Docteurs</div>
              <v-list-item-title class="text-h5  text-right">{{ counts.doctorCount }}</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">switch_account</v-icon>
              <div class="text-overline">Nos docteur</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="6" xs="12" md="6" lg="3">
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="green" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>access_time</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Rendez-vous</div>
              <v-list-item-title class="text-h5  text-right">{{ counts.confirmedAppointmentCount }}</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">check</v-icon>
              <div class="text-overline">confirmé</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="6" xs="12" md="6" lg="3">
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="#F44336" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>access_time_filled</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Rendez-vous</div>
              <v-list-item-title class="text-h5  text-right">{{ counts.unconfirmedAppointmentCount }}</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">check_box</v-icon>
              <div class="text-overline">non confirmé</div>
            </v-card-actions>
          </v-card>
        </v-col>
       
      </v-row>

      <v-row>
        <v-divider :thickness="3" class="border-opacity-90  tw-mb-5 tw-mt-3"></v-divider>
        <v-icon size="20">work</v-icon>
          <h6 class="black-text">Nos Docteurs </h6>
        </v-row>
      <v-row>




        <v-col xs="12" sm="6" md="4" lg="3" v-for="person in doctors" :key="person.id">
          <v-card class="text-center ma-3">
            <v-responsive class="pt-4">
              <v-avatar size="100" class="tw-red lighten-2">
                <img :src="person.profile_picture" alt="">
              </v-avatar>
            </v-responsive>
            <v-card-text>
              <div class="subheading"><strong> Dr.{{ person.name }}</strong></div>
              <div class="grey--text">{{ person.type.toUpperCase() }}</div>
            </v-card-text>
            <v-card-actions>
              <Update :user="person" @doctorDeleted="getDoctors" @doctorUpdated="getDoctors"/>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
      

      <v-row>
        <v-divider :thickness="3" class="border-opacity-90 tw-mb-5 tw-mt-3"></v-divider>
        <v-icon size="20">person</v-icon>
          <h6 class="black-text">Nos client</h6>
        </v-row>
      <v-row>




        <v-col xs="12" sm="6" md="4" lg="3" v-for="person in clients" :key="person.id">
          <v-card class="text-center ma-3">
            <v-responsive class="pt-4">
              <v-avatar size="100" class="tw-red lighten-2">
                <img :src="person.profile_picture" alt="">
              </v-avatar>
            </v-responsive>
            <v-card-text>
              <div class="subheading"><strong> Mr.{{ person.name }}</strong></div>
              <div class="grey--text">{{ person.type.toUpperCase() }}</div>
            </v-card-text>
            <v-card-actions>
              <v-btn outlined color="orange">
                Voir
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      
    </v-container>
  </div>
</template>

<script>
// @ is an alias to /src

import axios from 'axios';
import Update from '../components/UpdateDoctor.vue';

export default {
  name: 'team',
  components: {
    Update,
  },
  data : () => ({
    team: [
      {name: 'Iyad', role: 'web developer', avatar:'/img1.png'},
      {name: 'Reda', role: 'Graphic designer', avatar:'/img2.png'},
      {name: 'Zineb', role: 'web developer', avatar:'/img3.png'},
      {name: 'Hu TechGroup', role: 'Desktop developer', avatar:'/img4.png'},
    ],
    counts: {},
    doctors: [],
    clients:[],
  }),
  created() {
    this.fetchCounts();
    this.getDoctors();
    this.getClients()

  },
  methods: {
    fetchCounts() {
      axios.get('/sanctum/csrf-cookie').then(response => {
      axios.get('api/admin/counts') // Replace with the actual URL to your Laravel endpoint
        .then(response => {
          this.counts = response.data;
        })
        .catch(error => {
          console.error('Error fetching counts:', error);
        });})
    },
    getDoctors() {
    axios.get('api/doctors')
      .then(response => {
        this.doctors = response.data;
      })
      .catch(error => {
        console.error(error);
      });
     
  },
  getClients() {
    axios.get('/sanctum/csrf-cookie').then(response => {
      axios
        .get(`api/getClients/`)
        .then(response => {
          this.clients = response.data;
        })
        .catch(error => {
          console.error(error);
        });})
    },
  
  },  
}
</script>
<style>
.black-text {
  color: black;
}
</style>