<template>
    <div>
        <div class="card mb-3">

            <div class="card-header d-flex">
                <div class="mr-auto">
                    Roles
                </div> 
                <div class="ml-auto">
                    User Management > Roles
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(role, index) in roles" :key="index" v-on:click="edit(index)">
                            <td>{{ role.id }}</td>
                            <td>{{ role.name }}</td>
                            <td>{{ role.description }}</td>
                            <td>{{ role.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="loading" class="text-center">
                    <img src="/images/loader.gif" alt="loading" style="height: 50px">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" @click="$modal.show('create-role')" style="width: 120px">Create Role</button>
        
        <create-role-modal/>

        <edit-role-modal/>
    </div>
    
        
</template>

<script>
    import config from '../config.js';
    import CreateRoleModal from './roles/CreateRoleModal.vue';
    import EditRoleModal from './roles/EditRoleModal.vue';

    export default {
        components: {
            CreateRoleModal,
            EditRoleModal
        },
        data() {
            return {
                roles: {},
                loading: true
            }
        },
        mounted() {
            console.log('Role Component mounted.');
            axios.get(config.APP_URL + 'roles/get')
            .then(response => {
                if (response.data.status == 'success') {
                    this.roles = response.data.roles;   
                    this.loading = false; 
                }
                // console.log(response)
            }).catch(error => {
                console.log(error)
            });
        },
        methods: {
            edit: function(roleid) {
                var selected = this.roles[roleid];
                this.$modal.show('edit-role', {role: selected});
            },
        }
    }
</script>
