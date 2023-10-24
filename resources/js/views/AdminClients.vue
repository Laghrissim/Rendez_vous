<template>
  <div class="team">
    <v-container>
      <v-row>
          <hr class="section-divider" />
          <h6 class="h1-large">Nos clients</h6>
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

export default {
  name: 'team',
  components: {
   
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