<template>
    <modal name="edit-category" transition="pop-out" :width="modalWidth" :height="'auto'" @before-open="beforeOpen">
        <form class="p-4">
            <h1>Update Expense Category</h1>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  v-model="category.name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text"  v-model="category.description" class="form-control" placeholder="Enter Description">
            </div>

            <button type="button" v-on:click="editCategory" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'EditCategoryModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                category: {
                    category_id: '',
                    name: '',
                    description: '',
                },
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('Edit category Component mounted.');
        },
        methods: {
            editCategory: function() {
                if (!this.category.category_id) {
                    alert("Category not existing");
                    return false;
                }
                if (!this.category.name) {
                    alert("Name missing");
                    return false;
                }
                if (!this.category.description) {
                    alert("Description missing");
                    return false;
                }

                axios.put(config.APP_URL + 'expense-category/' + this.category.category_id, {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    category_id: this.category.category_id,
                    name: this.category.name,
                    description: this.category.description,
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("Expense Category successfully updated");
                        window.location.href = "/expense-category/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/expense-category/";
                });
            },
            beforeOpen (event) {
                let category = event.params.category;
                this.category.category_id = category.id;
                this.category.name = category.name;
                this.category.description = category.description;
            }
        },
        
    }
</script>