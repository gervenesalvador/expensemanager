<template>
    <div>
        <div class="card mb-3">

            <div class="card-header d-flex">
                <div class="mr-auto">
                    Expenses
                </div> 
                <div class="ml-auto">
                    Expense Management > Expenses
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Expense Category</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Entry Date</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(expense, index) in expenses" :key="index" v-on:click="edit(index)">
                            <td>{{ expense.category_name }}</td>
                            <td>${{ expense.amount }}</td>
                            <td>{{ expense.entry_date }}</td>
                            <td>{{ expense.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="loading" class="text-center">
                    <img src="/images/loader.gif" alt="loading" style="height: 50px">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" @click="$modal.show('create-expense')" style="width: 140px">Create Expense</button>
        
        <create-expense-modal/>

        <edit-expense-modal/>
    </div>
    
        
</template>

<script>
    import config from '../config.js';
    import CreateExpenseModal from './expense/CreateExpenseModal.vue';
    import EditExpenseModal from './expense/EditExpenseModal.vue';

    export default {
        components: {
            CreateExpenseModal,
            EditExpenseModal
        },
        data() {
            return {
                expenses: {},
                loading: true
            }
        },
        mounted() {
            console.log('Expenses Component mounted.');
            axios.get(config.APP_URL + 'expenses/get')
            .then(response => {
                if (response.data.status == 'success') {
                    this.expenses = response.data.expenses;   
                    this.loading = false; 
                }
                // console.log(response)
            }).catch(error => {
                console.log(error)
            });
        },
        methods: {
            edit: function(expenseid) {
                // console.log("edit");
                var selected = this.expenses[expenseid];
                this.$modal.show('edit-expense', {expense: selected});
            },
        }
    }
</script>
