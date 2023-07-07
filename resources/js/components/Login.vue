<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-6 offset-3">
                <form action="#" @submit.prevent="handleLogin">
                    <h3>Login For Clients</h3>
                <div class="form-row">
                    <input type="email" name="email" class="form-control" v-model="formData.email" placeholder="Adress Email">
                </div>
                <div class="form-row">
                    <input type="password" name="password" class="form-control" v-model="formData.password" placeholder="Password">
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {

            return {
                clients: [],
                formData: {
                    email: '',
                    password:'',
                }
            }

        },
        methods: {
            handleLogin(){
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login',this.formData).then(response => {
                        console.log(response);
                    });
                });
            }
        }
    } 
</script>

<style>
    .form-row {
        margin-bottom: 8px;
    }
</style>
