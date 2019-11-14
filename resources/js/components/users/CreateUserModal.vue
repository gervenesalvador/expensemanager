<template>
    <modal name="create-user" transition="pop-out" :width="modalWidth" :height="'auto'">
        <form class="p-4">
            <h1>Create User</h1>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  v-model="user.name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email"  v-model="user.email" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password"  v-model="user.password" class="form-control" placeholder="Enter password">
            </div>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" v-model="user.role_id">
                    <option value="" disabled selected>Select role...</option>
                    <option v-for="(role, index) in roles" :key="index" :value="role.id" >{{  role.name}}</option>
                </select>
            </div>

            <button type="button" v-on:click="createUser" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'CreateUserModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                user: {
                    name: '',
                    email: '',
                    password: '',
                    role_id: '',
                },
                roles: {},
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('CreateUser Component mounted.');
            axios.get(config.APP_URL + 'roles/get')
            .then(response => {
                if (response.data.status == 'success') {
                    this.roles = response.data.roles; 
                }
            }).catch(error => {
                console.log(error)
            });
        },
        methods: {
            createUser: function(){
                if (!this.user.name) {
                    alert("Name Required");
                    return false;
                }
                if (!this.user.email) {
                    alert("Email Required");
                    return false;
                }
                if (!this.user.password) {
                    alert("Password Required");;
                    return false;
                }
                if (!this.user.role_id) {
                    alert("Role Required");
                    return false;
                }

                axios.post(config.APP_URL + 'users', {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password,
                    role_id: this.user.role_id
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("Users successfully added");
                        window.location.href = "/users/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/users/";
                });
            },
        },
        
    }
</script>