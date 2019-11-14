<template>
    <modal name="create-category" transition="pop-out" :width="modalWidth" :height="'auto'">
        <form class="p-4">
            <h1>Create Expense Category</h1>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  v-model="category.name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text"  v-model="category.description" class="form-control" placeholder="Enter Description">
            </div>

            <button type="button" v-on:click="createCategory" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'CreateCategoryModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                category: {
                    name: '',
                    description: '',
                },
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('Create Expense Cateory Component mounted.');
            
        },
        methods: {
            createCategory: function(){
                if (!this.category.name) {
                    alert("Name Required");
                    return false;
                }
                if (!this.category.description) {
                    alert("Description Required");
                    return false;
                }

                axios.post(config.APP_URL + 'expense-category', {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    name: this.category.name,
                    description: this.category.description,
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("expense category successfully added");
                        window.location.href = "/expense-category/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/expense-category/";
                });
            }
        },
        
    }
</script>