<template>
    <modal name="create-role" transition="pop-out" :width="modalWidth" :height="'auto'">
        <form class="p-4">
            <h1>Create Role</h1>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  v-model="role.name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text"  v-model="role.description" class="form-control" placeholder="Enter Description">
            </div>

            <button type="button" v-on:click="createRole" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'CreateRoleModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                role: {
                    name: '',
                    description: '',
                },
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('CreateRole Component mounted.');
            
        },
        methods: {
            createRole: function(){
                if (!this.role.name) {
                    alert("Name Required");
                    return false;
                }
                if (!this.role.description) {
                    alert("description Required");
                    return false;
                }

                axios.post(config.APP_URL + 'roles', {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    name: this.role.name,
                    description: this.role.description,
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("Role successfully added");
                        window.location.href = "/roles/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/roles/";
                });
            }
        },
        
    }
</script>