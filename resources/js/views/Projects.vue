<template>
  <div class="appointments">
    <h2 class="ma-10">Vos rendez-vous</h2>
    <v-container v-if="appointments.length != 0 ">
      <v-layout  v-if="areAllAppointmentsMissed" row wrap class="mb-4" >
        <v-tooltip bottom>
          <template v-slot:activator="{ props: menu }">
            <v-btn small outlined color="green" @click="sortBy('title')" class="mr-2" dark v-bind="mergeProps(menu)">
              <v-icon left small>folder</v-icon>
              <span class="caption text-lowercase">Par titre de rendez-vous</span>
            </v-btn>
          </template>
          
          <span>Tri par titre</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ props: menu }">
            <v-btn small outlined color="blue" @click="sortBy('date')" class="mr-2" dark v-bind="mergeProps(menu)">
              <v-icon left small>person</v-icon>
              <span class="caption text-lowercase">Par Date</span>
            </v-btn>
          </template>
          <span>Tri par Date</span>
        </v-tooltip>
      </v-layout >
      <h4  v-if="areAllAppointmentsMissed">Rendez-vous</h4>       
      <v-card flat v-for="appointment in appointments" :key="appointment.id" class="mb-1">
        <div v-if="!isMissed(appointment)">
      <v-layout row wrap :class="`pa-3 appointment `" >
        <v-expansion-panels>
      <v-expansion-panel class="tw-pa-10"  :text="appointment.description">
        <template #title>
          <div class="tw-flex tw-items-center tw-justify-start tw-w-full">
            <span class="text-uppercase ">{{ appointment.title }}</span>
            <span class="font-weight-light tw-ml-10">{{ appointment.date }}</span>
            <span class="tw-font-weight-light tw-ml-10 "> <strong> Avec Dr. </strong>{{ doctors[appointment.doctor_id] }}</span>
            <span class="font-weight-light tw-ml-10" :class="{'text-green': appointment.status === 'confirmed', 'text-orange': appointment.status === 'unconfirmed'}">{{ appointment.status.toUpperCase() + (appointment.status === 'confirmed' ? ' BY DOCTOR' : '') }}</span>

          </div>
          <Edit :appointment="appointment" />
            <v-btn size="30" class="tw-float-right tw-mr-5"  text @click="deleteAppointment(appointment.id)">
              <v-icon size="20">close</v-icon>
              <v-dialog v-model="showDeleteConfirmation" max-width="500px">
                <v-card>
                  <v-card-title class="headline">Are you sure you want to delete this appointment?</v-card-title>
                  <v-card-actions class="flex justify-center">
                    <v-btn  color="primary" @click="deleteAppointmentConfirmed">Yes</v-btn>
                    <v-btn  color="primary" text @click="showDeleteConfirmation = false">No</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-btn>
            
        </template>
        <!-- Content for the expansion panel goes here -->
      </v-expansion-panel>
    </v-expansion-panels>
      </v-layout>
    </div>
    </v-card>
    <br><br><br> 
      <v-layout v-if="hasMissedAppointments " row wrap class="mb-4">
        <v-tooltip bottom>
          <template v-slot:activator="{ props: menu }">
            <v-btn small outlined color="green" @click="sortBy('title')" class="mr-2" dark v-bind="mergeProps(menu)">
              <v-icon left small>folder</v-icon>
              <span class="caption text-lowercase">Par titre de rendez-vous</span>
            </v-btn>
          </template>
          
          <span>Tri par titre</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ props: menu }">
            <v-btn small outlined color="blue" @click="sortBy('date')" class="mr-2" dark v-bind="mergeProps(menu)">
              <v-icon left small>person</v-icon>
              <span class="caption text-lowercase">Par Date</span>
            </v-btn>
          </template>
          <span>Tri par Date</span>
        </v-tooltip>
      </v-layout>
      <h4 v-if="hasMissedAppointments   " style="color: red;">Rendez-vous manqués</h4>       
      <v-card flat v-for="appointment in appointments" :key="appointment.id" class="mb-1">
        <div v-if="isMissed(appointment) ">
      <v-layout row wrap :class="`pa-3 appointment up`" >
        <v-expansion-panels>
      <v-expansion-panel class="tw-pa-10" :color="appointmentColor(appointment) " :text="appointment.description">
        <template #title>
          <div class="tw-flex tw-items-center tw-justify-start tw-w-full">
            <span class="text-uppercase ">{{ appointment.title }}</span>
            <span class="font-weight-light tw-ml-10">{{ appointment.date }}</span>
            <span class="tw-font-weight-light tw-ml-10 "> <strong> Avec Dr. </strong>{{ doctors[appointment.doctor_id] }}</span>
            <span class="font-weight-light tw-ml-10" :class="{'text-green': appointment.status === 'confirmed', 'text-orange': appointment.status === 'unconfirmed'}">{{ appointment.status.toUpperCase() + (appointment.status === 'confirmed' ? ' BY DOCTOR' : '') }}</span>

          </div>
          <EditTime @appointmentUpdated="handleAppointmentUpdated" :appointment="appointment" />

            <v-btn size="30" class="tw-float-right tw-mr-5"  text @click="deleteAppointment(appointment.id)">
              <v-icon size="20">close</v-icon>
              <v-dialog v-model="showDeleteConfirmation" max-width="500px">
                <v-card>
                  <v-card-title class="headline">Are you sure you want to delete this appointment?</v-card-title>
                  <v-card-actions class="flex justify-center">
                    <v-btn  color="primary" @click="deleteAppointmentConfirmed">Yes</v-btn>
                    <v-btn  color="primary" text @click="showDeleteConfirmation = false">No</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-btn>
            
        </template>
        <!-- Content for the expansion panel goes here -->
      </v-expansion-panel>
    </v-expansion-panels>
      </v-layout>
    </div>
    </v-card>
    </v-container>
    <v-container v-else> <p>Vous avez pas de rendez-Vous</p> </v-container>
  </div>
</template>

<script>
import { mergeProps } from 'vue'
import Edit from '../components/Edit.vue'
import EditTime from '../components/EditTime.vue'
import axios from 'axios';
import Pusher from 'pusher-js'

export default {
  name: 'appointments',
  components: {Edit,EditTime },
  data: () => ({
    appointments: [],
    showDeleteConfirmation: false,
    doctors: {},
  }),
  methods: {
    sortBy(prop) {
      this.appointments.sort((a, b) => (a[prop] < b[prop] ? -1 : 1))
    },
    deleteAppointment(appointmentId) {
    // Set the appointment ID to be deleted
    this.appointmentToDeleteId = appointmentId;
    // Show the delete confirmation dialog
    this.showDeleteConfirmation = true;
  },

  deleteAppointmentConfirmed() {
    axios.get('/sanctum/csrf-cookie').then(response => {
    axios
      .delete(`api/appointments/${this.appointmentToDeleteId}`)
      .then(() => {
        // Remove the deleted appointment from the local list
        this.appointments = this.appointments.filter(appointment => appointment.id !== this.appointmentToDeleteId);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      })
      .catch(error => {
        console.error(error);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      });})
  },

    mergeProps,
    getDoctorById(userId) {
      axios.get(`/api/doctor/${userId}`)
        .then(response => {
          this.doctors[userId] = response.data.name;// Store the username in the Vue data variable
        })
        .catch(error => {
          console.error(error);
        });},
     fetchAppointment()
     {
      axios.get('/sanctum/csrf-cookie').then(response => {
    axios
      .get('api/appointments')
      .then(response => {
        this.appointments = response.data
        this.appointments.forEach(appointment => {
          this.getDoctorById(appointment.doctor_id);
        });
      })
      .catch(error => {
        console.error(error)
      })})
      console.log(this.doctors)},
      handleAppointmentUpdated() {
      // When the appointment is updated, refetch the appointments
      this.fetchAppointment();
    },
  //   areAllAppointmentsConfirmed() {
  //   // Iterate through the appointments array
  //   for (const appointment of this.appointments) {
  //     // If any appointment is not confirmed, return false
  //     if (appointment.status !== 'confirmed') {
  //       return false;
  //     }
  //   }
  //   // If all appointments are confirmed, return true
  //   return true;
  // },

  },
  created() {
    // Récupérer les rendez-vous via la route /appointments
    
      this.fetchAppointment()
      // Pusher.logToConsole = true;

    //   var pusher = new Pusher('61f6c55d15bd653e0ec3', {
    //     cluster: 'eu'
    //   });

    //   var channel = pusher.subscribe('chat');
    //   channel.bind('my-event', function() {
    //   console.log("heloo")
    // });
  
  },
  

  computed: {
  appointmentColor() {
    return (appointment) => {
      return new Date(appointment.date).getTime() < new Date().getTime() ? 'red' : 'white';
    };
  },
  isMissed() {
    return (appointment) => {
      return new Date(appointment.date).getTime() < new Date().getTime() ;
    };
    
  },

  hasMissedAppointments() {
      // Check if there are any missed appointments in the appointments array
      return this.appointments.some(appointment => this.isMissed(appointment));
    },
    areAllAppointmentsMissed() {
    return this.appointments.some(appointment => !this.isMissed(appointment));},
    areAllAppointmentsConfirmed() {
    return this.appointments.some(appointment => appointment.status !== 'confirmed');},
},



}
</script>

<style>
.appointment {
  border-left: 4px solid #3cd1c2;
}
.appointment.no {
  border-left: 4px solid orange;
}
.appointment.up {
  border-left: 4px solid red;
}
.appointment.yes {
  border-left: 4px solid yellow;
}
.v-chip{
  color: #3cd1c2;
}
.p.ovnored {
  color: orange;
}
.p.up {
  color: red;
}
.p.yes {
  color: yellow;
}
h2 {
	color: #223150;
	font-weight: 700;
	font-size: 2rem;
	line-height: 2.5rem;
	letter-spacing: -0.4px;
}
h6{
  color:gray;
}
.text-green {
    color: green; /* Set your desired green color */
  }

.text-orange {
    color: orange; /* Set your desired blue color */
  }
</style>
