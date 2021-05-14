<template>
    <div>
        <div class="row no-margin">
            <div class="col-6">
                <h3>Users</h3>
            </div>
            <div class="col-6 text-right">
                <label class="">User Management / Users</label>
            </div>
        </div>

        <div class="row no-margin">

            <div class="col-12 py-4">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUser">
                    Add User
                </button>
            </div>

            <!-- Add User Modal -->
            <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" v-model="form.UserName">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-3 col-form-label">Email Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" v-model="form.UserEmail">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="addCategory" class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <select class="form-control" v-model="form.UserRole">
                                        <option value="" selected disabled hidden>Select role</option>
                                        <option v-for="r in roleList" :key="r.id" :value="r.id">{{ r.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" @click="submitUser">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 py-2">
                <table class="table table-sm table-striped">
                    <thead align="center">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Role</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <tr v-for="(user, index) in userList" :key="user.id">
                            <td>
                                <a href="#" @click="editUser(user, index)">{{ user.name }}</a>
                            </td>
                            <td> {{ user.email }} </td>
                            <td> {{ user.role }} </td>
                            <td> {{ user.created_at }} </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Update User Modal -->
                <div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Update Users</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="updateName" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="updateName" v-model="formEdit.userName">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="updateEmail" class="col-sm-3 col-form-label">Email Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="updateEmail" v-model="form.userEmail">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="updateRole" class="col-sm-3 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="updateRole" v-model="form.userRole">
                                                <option>Role</option>
                                                <option>Admin</option>
                                                <option>User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default ({
	props: ['roles_user', 'user_post'],
	data() {

		return {

            roleList: this.roles_user,
			userList: this.user_post,

			form: {
				UserName: "",
				UserRole: "",
				UserEmail: "",
			},

			formEdit: {
				UserName: "",
				UserRole: "",
				UserEmail: "",
			},

			selectedId: "",
		}
	},

    methods: {

        submitUser() {
			const vm = this;

			axios.post('/user', {
				name: this.form.UserName,
				email: this.form.UserEmail,
				role: this.form.UserRole
			})
			.then(function (response) {
				vm.userList.push(response.data.data);
				console.log(response.data.data);
				location.reload();

				vm.form.UserName = null
				vm.form.UserEmail = null
				vm.form.UserEmail = null

				alert(response.data.message)
				$('#addUser').modal('hide');
			})
			.catch(function (error) {
				console.log(error);
			});
		},
    }
})
</script>