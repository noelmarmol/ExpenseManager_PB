<template>
    <div>
        <div class="row no-margin">
			<div class="col-6">
				<h3>Expenses</h3>
			</div>
			<div class="col-6 text-right">
				<label class="">Expense Management / Expenses</label>
			</div>
		</div>

		<div class="row no-margin">

			<div class="col-12 py-4">
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addExpense">
					Add Expense
				</button>
			</div>

			<!-- Add Expense Modal -->
			<div class="modal fade" id="addExpense" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Add Expense</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
                            <div class="form-group row">
                                <label for="addCategory" class="col-sm-4 col-form-label">Expense Category</label>
                                <div class="col-sm-8">
                                    <select class="form-control" v-model="form.ExpenseCategory">
                                        <option value="" selected disabled hidden>Select category</option>
                                        <option v-for="cat in categoriesList" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="addAmount" class="col-sm-4 col-form-label">Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="addAmount" v-model="form.ExpenseAmount">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="addDate" class="col-sm-4 col-form-label">Entry Date</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="addDate" v-model="form.ExpenseDate">
                                    <!-- <input type="hidden" class="form-control" v-model="form.ExpenseUser" > -->
									<!-- <input type="hidden" name="user_id" v-model="user_id"> -->
									<input type="hidden" id="ExpenseUserID" value="Hello" />
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" @click="submitExpense">Save</button>
                        </div>
					</div>
				</div>
			</div>

			<div class="col-12 py-2">
                <div class="div-expense-table">
                    <table class="table table-sm table-striped expense-table">
                        <thead align="center">
                            <tr>
                                <th scope="col">Expense Category</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Entry Date</th>
                                <th scope="col">Created at</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr v-for="(expenses, index) in expenseList" :key="expenses.id">
                                <td>
                                    <a href="#" @click="editExpenses(expenses, index)">{{expenses.category_id}}</a>
                                </td>
                                <td>{{ expenses.amount }}</td>
                                <td>{{ expenses.entry_date }}</td>
                                <td>{{ expenses.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

				<!-- Update Role Modal -->
				<div class="modal fade" id="updateExpense" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Update Expense</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<div class="form-group row">
									<label for="addCategory" class="col-sm-4 col-form-label">Expense Category</label>
									<div class="col-sm-8">
										<select class="form-control" v-model="formEdit.ExpenseCategory">
											<option selected disabled hidden>Select category</option>
											<option v-for="cat in categoriesList" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<label for="addAmount" class="col-sm-4 col-form-label">Amount</label>
									<div class="col-sm-8">
										<input type="number" class="form-control" id="addAmount" v-model="formEdit.ExpenseAmount">
									</div>
								</div>

								<div class="form-group row">
									<label for="addDate" class="col-sm-4 col-form-label">Entry Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control" id="addDate" v-model="formEdit.ExpenseDate">
                                    	<!-- <input type="hidden" class="form-control" v-model="formEdit.ExpenseUser"> -->
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button class="btn btn-danger" @click="removeExpense">Delete</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button class="btn btn-primary" @click="updateExpense">Update</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
    </div>
</template>

<script>
export default ({
    props: ['categories', 'expenses_post'],
    data() {
        return {

            categoriesList: this.categories,
            expenseList: this.expenses_post,

            form: {
				ExpenseCategory: "",
				ExpenseAmount: "",
				ExpenseDate: "",
			},

            formEdit: {
				ExpenseCategory: "",
				ExpenseAmount: "",
				ExpenseDate: "",
			},

			selectedId: ""
        }
    },

    methods: {

        submitExpense() {
			const vm = this;

			axios.post('/expense', {
				category_id: parseInt(this.form.ExpenseCategory),
				amount: parseInt(this.form.ExpenseAmount),
				entry_date: this.form.ExpenseDate
			})
			.then(function (response) {
				// vm.expenseList.push(response.data.data);
				location.reload();

				vm.form.ExpenseCategory = null
				vm.form.ExpenseAmount = null
				vm.form.ExpenseDate = null

				alert(response.data.message)
				$('#addExpense').modal('hide');
			})
			.catch(function (error) {
				console.log(error);
			});
		},

		editExpenses(expenses) {

			const vm = this;
			vm.selectedId = expenses.id

			vm.formEdit.ExpenseCategory = expenses.category_id;
			vm.formEdit.ExpenseAmount = expenses.amount;
			vm.formEdit.ExpenseDate = expenses.entry_date;

			$('#updateExpense').modal('show');
		},

		updateExpense() {
			const vm = this;

			axios.put('/expense/' + vm.selectedId, {
				category_id: vm.formEdit.ExpenseCategory,
				amount: vm.formEdit.ExpenseAmount,
				entry_date: vm.formEdit.ExpenseDate
			})
			.then(function (response) {
				alert(response.data.message) 
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		},

		removeExpense() {
			const vm = this;

			axios.delete('/expense/' + vm.selectedId)
			.then(function (response) {
				alert(response.data.message) 
				$('#updateExpense').modal('hide');
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		}
    }
})
</script>

<style>
.div-expense-table {
    height: 300px;
    overflow-y: auto;
}
</style>
