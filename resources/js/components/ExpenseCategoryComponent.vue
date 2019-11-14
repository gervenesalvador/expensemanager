<template>
    <div>
        <div class="card mb-3">

            <div class="card-header d-flex">
                <div class="mr-auto">
                    Expense Categories
                </div> 
                <div class="ml-auto">
                    Expense Management > Expense Categories
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
                        <tr v-for="(category, index) in categories" :key="index" v-on:click="edit(index)">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td>{{ category.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="loading" class="text-center">
                    <img src="/images/loader.gif" alt="loading" style="height: 50px">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" @click="$modal.show('create-category')" style="width: 210px">Create Expense Category</button>
        
        <create-category-modal/>
        
        <edit-category-modal/>
        
    </div>
        
</template>

<script>
    import config from '../config.js';
    import CreateCategoryModal from './expense_category/CreateCategoryModal.vue';
    import EditCategoryModal from './expense_category/EditCategoryModal.vue';

    export default {
        components: {
            CreateCategoryModal,
            EditCategoryModal
        },
        data() {
            return {
                categories: {},
                loading: true
            }
        },
        mounted() {
            console.log('Expense Category Component mounted.');
            axios.get(config.APP_URL + 'expense-category/get')
            .then(response => {
                if (response.data.status == 'success') {
                    this.categories = response.data.expense_category;   
                    this.loading = false; 
                }
                // console.log(response)
            }).catch(error => {
                console.log(error)
            });
        },
        methods: {
            edit: function(categoryid) {
                console.log(categoryid)
                var selected = this.categories[categoryid];
                this.$modal.show('edit-category', {category: selected});
            },
        }
    }
</script>
