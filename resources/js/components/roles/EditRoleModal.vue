<template>
    <modal name="edit-role" transition="pop-out" :width="modalWidth" :height="'auto'" @before-open="beforeOpen">
        <form class="p-4">
            <h1>Update Role</h1>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  v-model="role.name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text"  v-model="role.description" class="form-control" placeholder="Enter Description">
            </div>

            <button type="button" v-on:click="editRole" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'EditRoleModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                role: {
                    role_id: '',
                    name: '',
                    description: '',
                },
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('EditRole Component mounted.');
        },
        methods: {
            editRole: function() {
                if (!this.role.role_id) {
                    alert("Role ID missing");
                    return false;
                }
                if (!this.role.name) {
                    alert("Name missing");
                    return false;
                }
                if (!this.role.description) {
                    alert("Description missing");
                    return false;
                }

                axios.put(config.APP_URL + 'roles/' + this.role.role_id, {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    role_id: this.role.role_id,
                    name: this.role.name,
                    description: this.role.description,
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("Role successfully updated");
                        window.location.href = "/roles/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/roles/";
                });
            },
            beforeOpen (event) {
                let role = event.params.role;
                this.role.role_id = role.id;
                this.role.name = role.name;
                this.role.description = role.description;
            }
        },
        
    }
</script>