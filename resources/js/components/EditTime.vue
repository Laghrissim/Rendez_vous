  <template>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="800px">
        <template  v-slot:activator=" { props: menu2  } " >
          <!-- <v-btn outlined  color="teal lighten-3" dark v-bind="mergeProps(menu)">Modifier rendez-vous</v-btn> -->
          <v-btn size="30"  text class="tw-float-right tw-mr-5" v-bind="mergeProps(menu2)" >
              <v-icon size="20">update</v-icon>
            </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Modifier Date rendez-vous</span>
          </v-card-title>
          <v-form class="px-3" ref="form" @submit.prevent="UpdateAppointment">
          <v-card-text>
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
            
            <template v-slot:activator="{ props: menu1  }">
              <v-text-field
                v-model="formattedDate"
                label="Date"
                hint="MM-DD-YYYY H:M:S format"
                persistent-hint
                prepend-icon="event"
                @click="menu1 = true"
                v-bind="mergeProps(menu1)"
              ></v-text-field>
            </template>
            <VDatePicker v-model="date" mode="dateTime" is24hr view="weekly" :disabled-dates="disabledDates" :rules="rules" />
            
          </v-menu>
          </v-col>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">Fermer</v-btn>
            <v-btn color="green" type="submit" text outlined v-on:click="Redirect ">Envoyer</v-btn> 
          </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
    </v-row>
     <v-dialog v-model="successDialog" max-width="400px" >
       <v-card >
         <v-card-title style="text-align: center;">Update Successful</v-card-title>
         <v-card-actions class="flex justify-center">
           <v-btn color="green" text @click="successDialog = false">OK</v-btn>
         </v-card-actions>
       </v-card>
     </v-dialog>
  </template>

  <script>
  import { mergeProps , computed ,watch ,ref} from 'vue'
  import moment from 'moment';
  import { useDate } from 'vuetify/labs/date'
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  export default {
    emits: ['appointmentUpdated'],


      data: vm => ({
        dialog: false,
        title:'',
        due:null,
        time:'',
        date: '',
        formattedDate: vm.appointment.date, 
        allDates:[],
        allHoures:[],
        successDialog: false,

      
        menu1: false,
        inputRules: [
            v => v.length >= 3 || 'Minimum lenght is 3 charachters' 
        ]
        
      }),
      props: {
        appointment: {
        type: Object,
        required: true,
      },
      },

      watch: {
        date(newDate){
          // const originalDate = new Date(newDate);
          this.formattedDate = newDate ? moment(newDate).format('YYYY-MM-DD HH:mm') : '';
          this.menu1=false
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
        UpdateAppointment() {
      // Create an object with the form data
      const formData = {
          title: this.appointment.title,
          description: this.appointment.description,
          date: this.formattedDate,
        };

        axios.get('/sanctum/csrf-cookie').then(() => {
        axios
          .put(`api/appointments/edit/${this.appointment.id}`, formData)
          .then(() => {
            console.log('Appointment updated successfully');
            this.dialog = false;
            this.successDialog= true;
            this.$emit('appointmentUpdated');
            // Update the parent component's appointment list (if needed)
          })
          .catch(error => {
            console.error(error);
            // Handle any errors
          });})
      },
      },

      
    
    
      
    mounted() {
      
      
      // this.getHoures(this.allDates)

    },


    
      components:{
        
      }


  }
  </script>