<template>
    <modal name="edit-user" transition="pop-out" :width="modalWidth" :height="'auto'" @before-open="beforeOpen">
        <form class="p-4">
            <h1>Update User</h1>
            <input type="hidden" name="user_id" id="user_id" value="">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  v-model="user.name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email"  v-model="user.email" class="form-control" placeholder="Enter email">
            </div>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" v-model="user.role_id">
                    <option value="" disabled selected>Select role...</option>
                    <option v-for="(role, index) in roles" :key="index" :value="role.id" >{{ role.name}}</option>
                </select>
            </div>

            <button type="button" v-on:click="editUser" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'EditUserModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                user: {
                    user_id: '',
                    name: '',
                    email: '',
                    role_id: '',
                },
                roles: {},
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('EditUser Component mounted.');
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
            editUser: function() {
                if (!this.user.user_id) {
                    alert("Userid missing");
                    return false;
                }

                if (!this.user.name) {
                    alert("Name Required");
                    return false;
                }
                if (!this.user.email) {
                    alert("Email Required");
                    return false;
                }
                if (!this.user.role_id) {
                    alert("Role Required");
                    return false;
                }

                axios.put(config.APP_URL + 'users/' + this.user.user_id, {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    user_id: this.user.user_id,
                    name: this.user.name,
                    email: this.user.email,
                    role_id: this.user.role_id
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("Users successfully added");
                        window.location.href = "/users/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/users/";
                });
            },
            beforeOpen (event) {
                let user = event.params.user;
                this.user.user_id = user.user_id;
                this.user.name = user.name;
                this.user.email = user.email;
                this.user.role_id = user.role_id;
            }
        },
        
    }
</script>