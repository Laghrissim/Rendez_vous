<template>
  <div class="team">
    <h2 class="ma-10">Votre client</h2>
    <v-container>
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
                <Message :doctor="person" />
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
import Message from '../components/Message.vue'



export default {
  name: 'team',
  components: {
   Message,
  },
  data : () => ({
    team: [
      {name: 'Iyad', role: 'web developer', avatar:'/img1.png'},
      {name: 'Reda', role: 'Graphic designer', avatar:'/img2.png'},
      {name: 'Zineb', role: 'web developer', avatar:'/img3.png'},
      {name: 'Hu TechGroup', role: 'Desktop developer', avatar:'/img4.png'},
    ],     
     
     clients:[],
     user: {},

  }),
  methods: {

  getClientsForDoctor() {
      axios
        .get(`api/doctors/${this.user.id}`)
        .then(response => {
          this.clients = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    checkAuthentication() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.get('api/check-authentication').then((response) => {
          if (response.data.authenticated) {
            axios.get('/api/user').then((response) => {
              console.log(response);
              this.user = response.data;
              this.getClientsForDoctor();
            });
          }
        });
      });
    },
  },
  
  created() {
    
    this.checkAuthentication();

    },
}
</script>
<style>
h2 {
	color: #223150;
	font-weight: 700;
	font-size: 2rem;
	line-height: 2.5rem;
	letter-spacing: -0.4px;
}
</style>
