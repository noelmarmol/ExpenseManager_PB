<template>
    <div>
        <div class="row no-margin">
            <div class="col-6">
                <h3>Expense Categories</h3>
            </div>
            <div class="col-6 text-right">
                <label class="">Expense Management / Expense Categories</label>
            </div>
        </div>

        <div class="row no-margin">

            <div class="col-12 py-4">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategory">
                    Add Category
                </button>
            </div>

            <!-- Add Role Modal -->
            <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="addName" class="col-sm-3 col-form-label" required>Display Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="addCategoryName" v-model="form.categoryName">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="addDescription" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="addCategoryDescription" v-model="form.categoryDescription"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" @click="submitCategory">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 py-2">
                <table class="table table-sm table-striped">
                    <thead align="center">
                        <tr>
                            <th scope="col">Display Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <tr v-for="(category, index) in categoryList" :key="category.id">
                            <td>
                                <a href="#" @click="editCategory(category, index)">{{ category.name }}</a>
                            </td>
                            <td>{{ category.description }}</td>
                            <td>{{ category.created_at }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Update Role Modal -->
                <div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Update Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="updateName" class="col-sm-3 col-form-label">Display Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="updateCategoryName"  v-model="formEdit.categoryName">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="updateDescription" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="updateCategoryDescription" rows="3"  v-model="formEdit.categoryDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" @click="removeCategory">Delete</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" @click="updateCategory">Update</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    props: ['category_post'],
    data() {
		return {
			categoryList: this.category_post,
			form: {
				categoryName: "",
				categoryDescription: ""
			},

			formEdit: {
				categoryName: "",
				categoryDescription: ""
			},

			selectedId: ""
		}
	},

    methods: {
        submitCategory() {

            const vm = this;

            if(vm.form.categoryName == "" && vm.form.categoryDescription == "") {
                $('#addCategoryName').addClass("border border-danger")
                $('#addCategoryDescription').addClass("border border-danger")
            }

            else if (vm.form.categoryName == "") {
                $('#addCategoryName').addClass("border border-danger")
                $('#addCategoryDescription').removeClass("border border-danger")
            }

            else if(vm.form.categoryDescription == "") {
                $('#addCategoryName').removeClass("border border-danger")
                $('#addCategoryDescription').addClass("border border-danger")
            }

            else {

                $('#addCategoryName').removeClass("border border-danger")
                $('#addCategoryDescription').removeClass("border border-danger")

                axios.post('/category', {
                    name: this.form.categoryName,
                    description: this.form.categoryDescription
                })
                .then(function (response) {
                    vm.categoryList.push(response.data.data);

                    vm.form.categoryName = null
                    vm.form.categoryDescription = null

                    alert(response.data.message)
                    $('#addCategory').modal('hide');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
		},

        editCategory(category) {

			const vm = this;
			vm.selectedId = category.id

			vm.formEdit.categoryName = category.name;
			vm.formEdit.categoryDescription = category.description;

			$('#updateCategory').modal('show');
		},

        updateCategory() {
			const vm = this;

			axios.put('/category/' + vm.selectedId, {
				name: vm.formEdit.categoryName,
				description: vm.formEdit.categoryDescription
			})
			.then(function (response) {
				alert(response.data.message) 
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		},

        removeCategory() {
			const vm = this;

			axios.delete('/category/' + vm.selectedId)
			.then(function (response) {
				alert(response.data.message) 
				$('#updateCategory').modal('hide');
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		}
    }
}
</script>