<template>
    <modal name="edit-expense" transition="pop-out" :width="modalWidth" :height="'auto'" @before-open="beforeOpen">
        <form class="p-4">
            <h1>Update Expense</h1>
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

            <button type="button" v-on:click="editExpense" class="btn btn-primary">Submit</button>
        </form>
    </modal>
</template>

<script>

    const MODAL_WIDTH = 656
    import config from '../../config.js';

    export default {
        name: 'EditExpenseModal',
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                expense: {
                    expense_id: '',
                    category_id: '',
                    amount: '',
                    entry_date: ''
                },
                categories: []
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH;
        },
        mounted() {
            console.log('Edit category Component mounted.');
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
            editExpense: function() {
                let isNumeric = function(value) {
                    return !isNaN(value - parseFloat(value));
                }
                if (!this.expense.expense_id) {
                    alert("Expenses not existing");
                    return false;
                }
                if (!this.expense.category_id) {
                    alert("Category Required");
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

                axios.put(config.APP_URL + 'expenses/' + this.expense.category_id, {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    expense_id: this.expense.expense_id,
                    category_id: this.expense.category_id,
                    amount: this.expense.amount,
                    entry_date: this.expense.entry_date,
                }).then(response => {
                    if (response.data.status == 'success') {
                        alert("Expense Category successfully updated");
                        window.location.href = "/expenses/";
                    } else {
                        alert("Something went wront. ("+ response.data.error.message +")");
                    }
                }).catch(error => {
                    // console.log(error)
                    alert("Something went wrong. Please Try Again");
                    window.location.href = "/expenses/";
                });
            },
            beforeOpen (event) {
                let expense = event.params.expense;
                this.expense.expense_id = expense.expense_id;
                this.expense.category_id = expense.category_id;
                this.expense.amount = expense.amount;
                this.expense.entry_date = expense.entry_date;
            }
        },
        
    }
</script>