  <template>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="800px">
        <template  v-slot:activator=" { props: menu2  } "  >
          <!-- <v-btn outlined  color="teal lighten-3" dark v-bind="mergeProps(menu)">Modifier rendez-vous</v-btn> -->
          <v-btn size="30"  text  class="tw-ml-10" outlined color="orange" v-bind="mergeProps(menu2)" >
            <v-icon small left>message</v-icon>
                <span>Message</span>
            </v-btn>
        </template>
      
        <div >
          <v-app app>
            <v-app-bar color="blue" app>
              <v-app-bar-nav-icon @click="dialog = false">
              <v-icon color="white">arrow_back</v-icon>    
              </v-app-bar-nav-icon>
              <v-toolbar-title class="white--text"
                >DR.{{ doctor.name }} </v-toolbar-title>
            </v-app-bar>
            <v-container class="fill-height">
              <v-row class="fill-height pb-14" align="end">
                <v-col>
                  <div v-for="(item, index) in chat" :key="index" 
                    :class="['d-flex flex-row align-center my-2', item.sender_id == this.user.id ? 'justify-end': null]">
                    <v-btn v-if="item.sender_id == this.user.id" size="20" class="tw-float-left tw-mr-5"  text @click="deleteMessage(item.id)">
                    <v-icon size="10">close</v-icon>
                  </v-btn>
                  <span v-if="item.sender_id == this.user.id" class="blue--text mr-3">{{ item.message }}</span>
                  <v-avatar :color="item.sender_id == this.user.id  ? 'indigo': 'white'" size="50">
                    <!-- <span class="white--text">You</span> -->
                    <img :src=" item.sender_id == this.user.id  ? this.user.profile_picture : this.doctor.profile_picture" alt="">                  </v-avatar>
                  <span v-if="item.sender_id != this.user.id" class="blue--text ml-3">{{ item.message }}</span>
                  
                </div>
                </v-col>
              </v-row>
            </v-container>
            <v-footer fixed>
              <v-container class="ma-0 pa-0">
                <v-row no-gutters>
                  <v-col>
                    <div class="d-flex flex-row align-center">
                      <v-text-field v-model="msg" placeholder="Type Something" @keypress.enter="send"></v-text-field>
                      <v-btn  size="50px" icon class="ml-4 tw-mb-5" @click="send"><v-icon>send</v-icon></v-btn>
                    </div>
                  </v-col>
                </v-row>
              </v-container>
            </v-footer>
          </v-app>
        </div>
      </v-dialog>
      </v-row>
  </template>

  <script>
  import { mergeProps , computed ,watch ,ref} from 'vue'
  import moment from 'moment';
  import { useDate } from 'vuetify/labs/date'
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  import Pusher from 'pusher-js'

  export default {
    


      data: vm => ({
        dialog: false,
        title:'',
        due:null,
        time:'',
        date: '',
        formattedDate:'',
        allDates:[],
        allHoures:[],
        successDialog: false,
        chat: [],
        msg: null,
        user:{},

      
        menu1: false,
        inputRules: [
            v => v.length >= 3 || 'Minimum lenght is 3 charachters' 
        ]
        
      }),
      props: {
        doctor: {
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
        formattedDate(newDate){
          // const originalDate = new Date(newDate);
          this.appointment.date = newDate;
          
        }
      },
        
    

    methods: {
    send: function(){
      this.chat.push(
      {
        sender_id: this.user.id,
        message: this.msg
      })
      axios.post('/api/messages', {
        message: this.msg,
        sender_id: this.user.id, // Replace with the sender's user ID (if you have a logged-in user, you can get their ID from the backend)
        receiver_id: this.doctor.id, // Replace with the receiver's user ID
      })
      .then(response => {
        console.log(response.data.message); // Optional: Show a success message
      })
      .catch(error => {
        console.error(error); // Optional: Show an error message
      });

      this.msg = null
     
    },
    addReply(){
      this.chat.push({
        from: "sushant",
        msg: "Hmm"
      })
    },
    async getMessages() {
  try {
    await this.checkAuthentication();// Wait for checkAuthentication to complete
    axios
      .get('/api/messages', {
        params: {
          user1_id: this.user.id, // Replace with the logged-in user's ID
          user2_id: this.doctor.id, // Replace with the doctor's ID
        },
      }) // Call the route to get all messages
      .then((response) => {
        this.chat = response.data.messages;
        this.chat = Object.values(this.chat).sort((a, b) => a.id - b.id);
      })
      .catch((error) => {
        console.error(error);
      });
  } catch (error) {
    console.error(error);
  }
},

    mergeProps,
    async checkAuthentication() {
      try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.get('/api/check-authentication');
        if (response.data.authenticated) {
          const userResponse = await axios.get('/api/user');
          this.user = userResponse.data;
        }
      } catch (error) {
        console.error(error);
      }
    },
    async deleteMessage(messageId) {
      try {
        await axios.delete(`/api/messages/${messageId}`);
        // Remove the deleted message from the chat array
        this.chat = this.chat.filter((message) => message.id !== messageId);
        console.log('Message deleted successfully');
      } catch (error) {
        console.error(error);
      }
    },
  },
  

      
    
    
      
    async mounted() {
      await this.getMessages();
       // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('61f6c55d15bd653e0ec3', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('chat');
    channel.bind('message', async (data) => {
        console.log('hey')
        await this.getMessages();
    });

      

    },


    
      components:{
        
      }


  }
  </script>