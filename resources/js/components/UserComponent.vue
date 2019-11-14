<template>
    <div>
        <div class="card mb-3">
            <div class="card-header d-flex">
                <div class="mr-auto">
                    Users
                </div> 
                <div class="ml-auto">
                    User Management > Users
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody v-if="users">
                        <tr v-for="(user, index) in users" :key="index" v-on:click="edit(index)">
                            <td>{{ user.user_id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role }}</td>
                            <td>{{ user.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="loading" class="text-center">
                    <img src="/images/loader.gif" alt="loading" style="height: 50px">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" @click="$modal.show('create-user')" style="width: 140px">Create User</button>
        
        <create-user-modal/>

        <edit-user-modal/>
    </div>
    
        
</template>

<script>
    import config from '../config.js';
    // import DemoLoginModal from './users/DemoLoginModal.vue';
    import CreateUserModal from './users/CreateUserModal.vue';
    import EditUserModal from './users/EditUserModal.vue';

    export default {
        components: {
            // DemoLoginModal,
            CreateUserModal,
            EditUserModal
        },
        data() {
            return {
                users: {},
                loading: true
            }
        },
        mounted() {
            console.log('User Component mounted.');
            axios.get(config.APP_URL + 'users/get')
            .then(response => {
                if (response.data.status == 'success') {
                    this.users = response.data.users;   
                    this.loading = false; 
                }
                // console.log(response)
            }).catch(error => {
                console.log(error)
            });
        },
        methods: {
            edit: function(userid) {
                var selected = this.users[userid];
                // console.log(selected);
                this.$modal.show('edit-user', {user: selected});
            },
        }
    }
</script>
