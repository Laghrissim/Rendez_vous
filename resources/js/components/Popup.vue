<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="800px">
      <template  v-slot:activator=" { props: menu  } " >
        <a class="btn-solid-lg " dark v-bind="mergeProps(menu)">Demandez Rendez-vous</a>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Nouveau rendez-vous</span>
        </v-card-title>
         <v-form class="px-3" ref="form" @submit.prevent="sendAppointment">
        <v-card-text>
           
                <v-text-field label="Title" v-model="title" prepend-icon="folder" :rules="inputRules"></v-text-field>
                <v-textarea label="Information" v-model="content" prepend-icon="edit" :rules="inputRules"></v-textarea>
                <v-select
                  v-model="selectedDoctorName"
                  label="Selectioner Votre Docteur"
                  :items="doctors.map(doctor => doctor.name)" 
                  outlined
                  prepend-icon="account_box"

                ></v-select>
                <v-col cols="12" lg="6">
                 <v-menu 
          ref="menu1"
          v-model="menu1"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"

        >
          <template v-slot:activator="{ props: menu  }">
            <v-text-field
              v-model="formattedDate"
              label="Date"
              hint="MM-DD-YYYY H:M:S format"
              persistent-hint
              prepend-icon="event"
              @click="menu1 = true"
              v-bind="mergeProps(menu)"
              readonly
            ></v-text-field>
          </template>
          <VDatePicker v-model="date" mode="dateTime" is24hr view="weekly" :disabled-dates="disabledDates" :rules="rules" />
          
        </v-menu>
        </v-col>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Fermer</v-btn>
          <v-btn color="green" type="submit" text outlined @click="Redirect">Envoyer</v-btn>
        </v-card-actions>
         </v-form>
      </v-card>
    </v-dialog>
  </v-row>
  <v-dialog v-model="successDialog" max-width="400px" >
       <v-card >
         <v-card-title style="text-align: center;">Appointment created successfully</v-card-title>
         <v-card-actions class="flex justify-center">
           <v-btn color="green" text @click="successDialog = false">OK</v-btn>
         </v-card-actions>
       </v-card>
     </v-dialog>
</template>

<script>
import { mergeProps , computed ,watch ,ref} from 'vue'
import moment from 'moment';
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
  


    data: vm => ({
      dialog: false,
      title:'',
      content:'',
      due:null,
      time:'',
      date: '',
      formattedDate:'',
      allDates:[],
      allHoures:[],
      successDialog:false,
      doctors: [],
      selectedDoctorName: null, // Variable to store the selected doctor's name
      selectedDoctorId: null,
      
     
      menu1: false,
      inputRules: [
          v => v.length >= 3 || 'Minimum lenght is 3 charachters' 
      ]
      
    }),

    watch: {
      date(newDate){
        // const originalDate = new Date(newDate);
        this.formattedDate = newDate ? moment(newDate).format('YYYY-MM-DD HH:mm') : '';
        
      },
        selectedDoctorName(newVal) {
            // Find the corresponding doctor object based on the selectedDoctorName
            const selectedDoctor = this.doctors.find(doctor => doctor.name === newVal);

            // Update the selectedDoctorId with the ID of the selected doctor
            this.selectedDoctorId = selectedDoctor ? selectedDoctor.id : null;
          },
      },
      
  setup() {
    const disabledDates = ref([
      { start: null, end: new Date()  },
      {
        repeat: {
          weekdays: [1, 7],
        },
      },
    ]);

    const allHoures = ref([]);
    const alldates = ref([]);
    const transformedData = ref([]);
    const formattedDate = ref([]);
    const formattedHour = ref([]);
    const formattedMonth = ref([]);

   

    const getDates = () => {
      axios
        .get('api/getDates')
        .then((response) => {
          
          allHoures.value = Object.values(response.data).map(date => parseInt(moment(date).format('HH')));
          transformedData.value = Object.entries(response.data).map(([key, date]) => {
          const formattedDate = moment(date).format('DD');
          const formattedHour = moment(date).format('HH');
          const formattedMonth = moment(date).format('MM');
            return { day: formattedDate, hour: formattedHour , month: formattedMonth };
          });

   

          // console.log(allHoures.value);
          
          
        })
        .catch((error) => {
          console.error(error);
        });
    };
    const rules = computed(() => ({
  hours: (hour, { day,month }) => {
    
    const selectedHours = transformedData.value
      .filter((item) => parseInt(item.month) === month)
      .filter((item) => parseInt(item.day) === day)
      .map((item) => parseInt(item.hour));

    return !selectedHours.includes(hour) && (hour >= 8 && hour <= 17);
  },
  minutes: 0,
}));

    getDates(); 
    const router = useRouter();
    const Redirect = () =>{
      
        router.push('/projects');
        
    }
    return {
      rules,
      disabledDates,
      Redirect,
      getDates,
    };
  },

    methods: {
      
      mergeProps,
      sendAppointment() {
    // Create an object with the form data
    const formData = {
      title: this.title,
      description: this.content,
      date: this.formattedDate,
      doctor_id: this.selectedDoctorId,
    };

    // Send a POST request to the backend API
    axios.get('/sanctum/csrf-cookie').then(() => {
      axios
        .post('api/appointments', formData)
        .then(() => {
          // Handle the successful response
          this.successDialog=true;
          console.log('Appointment created successfully');
          // Clear the form fields
          this.title = '';
          this.content = '';
          this.date = null;
          this.formattedDate = '';
          this.dialog = false;
          this.getDates();
         
          // location.reload();
         
        })
        .catch((error) => {
          // Handle any errors
          console.error(error);
        });
    });
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
  
 
      
    },
    created() {
      this.getDoctors();
    },

    

   
    


}
</script>