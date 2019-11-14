<template>
    <modal name="create-expense" transition="pop-out" :width="modalWidth" :height="'auto'">
        <form class="p-4">
            <h1>Create Expense</h1>
            <div class="form-group">
                <label for="category">Categories</label>
                <select class="form-control" id="category" v-model="expense.category_id">
                    <option value="" disabled selected>Select Category...</option>
                    <option v-for="(category, index) in categories" :key="index" :value="category.id" >{{ category.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Amount</label>
                <input type="number" v-model="expense.amount" class="form-control">
            </div>
            <div class="form-group">
                <label for="entry_date">Entry Date</label>
                <input type="date" v-model="expense.entry_date" class="form-control">
            </div>
            
            <button type="button" v-on:click="createExpense" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'CreateExpenseModal',
        components: {
        },
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                expense: {
                    category_id: '',
                    amount: '',
                    entry_date: ''
                },
                categories: []
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
        },
        mounted() {
            console.log('CreateExpense Component mounted.');
            axios.get(config.APP_URL + 'expense-category/get')
            .then(response => {
                if (response.data.status == 'success') {
                    this.categories = response.data.expense_category; 
                }
            }).catch(error => {
                console.log(error)
            });
        },
        methods: {
            createExpense: function(){
                let isNumeric = function(value) {
                    return !isNaN(value - parseFloat(value));
                }
                if (!this.expense.category_id) {
                    alert("category_id Required");
                    return false;
                }
                if (!this.expense.amount) {
                    alert("amount Required");
                    return false;
                }
                if (!isNumeric(this.expense.amount)) {
                     alert("invalid amount");
                    return false;
                }
                 if (!this.expense.entry_date) {
                    alert("Entry Date Required");
                    return false;
                }
                
                axios.post(config.APP_URL + 'expenses', {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    category_id: this.expense.category_id,
                    amount: this.expense.amount,
                    entry_date: this.expense.entry_date,
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("expenses successfully added");
                        window.location.href = "/expenses/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/expenses/";
                });
            }
        },
        
    }
</script>