<template>
	<div>
		<div class="row no-margin">
			<div class="col-6">
				<h3>Roles</h3>
			</div>
			<div class="col-6 text-right">
				<label class="">User Management / Roles</label>
			</div>
		</div>

		<div class="row no-margin">

			<div class="col-12 py-4">
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRole">
					Add Role
				</button>
			</div>

			<!-- Add Role Modal -->
			<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Add Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="form-group row">
								<label for="inputName" class="col-sm-3 col-form-label">Display Name</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" v-model="form.roleName" required>
								</div>
							</div>

							<div class="form-group row">
								<label for="inputDescription" class="col-sm-3 col-form-label">Description</label>
								<div class="col-sm-9">
									<textarea class="form-control" rows="3" v-model="form.roleDescription" required></textarea>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" @click="submitRole">Save</button>
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
						<tr v-for="(role, index) in roleList" :key="role.id">
							<td>
								<a href="#" @click="edit(role, index)">{{ role.name }}</a>
							</td>
							<td> {{ role.description }} </td>
							<td> {{ role.created_at }} </td>
						</tr>
					</tbody>
				</table>

				<!-- Update Role Modal -->
				<div class="modal fade" id="updateRecord" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Update Role</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<div class="form-group row">
									<label for="inputName" class="col-sm-3 col-form-label">Display Name</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" v-model="formEdit.roleName">
									</div>
								</div>

								<div class="form-group row">
									<label for="inputDescription" class="col-sm-3 col-form-label">Description</label>
									<div class="col-sm-9">
										<textarea class="form-control" rows="3" v-model="formEdit.roleDescription"></textarea>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-danger" @click="remove">Delete</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button class="btn btn-primary" @click="updateRole">Update</button>
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
	props: ['role_post'],
	data() {
		return {
			roleList: this.role_post,
			form: {
				roleName: "",
				roleDescription: ""
			},

			formEdit: {
				roleName: "",
				roleDescription: ""
			},

			selectedId: ""
		}
	},

	methods: {
		submitRole() {

			const vm = this;

			axios.post('/role', {
				name: this.form.roleName,
				description: this.form.roleDescription
			})
			.then(function (response) {
				vm.roleList.push(response.data.data);

				vm.form.roleName = null
				vm.form.roleDescription = null

				alert(response.data.message)
				$('#addRole').modal('hide');
			})
			.catch(function (error) {
				console.log(error);
			});
		},

		edit(role) {

			const vm = this;
			vm.selectedId = role.id

			vm.formEdit.roleName = role.name; // role.name is field name
			vm.formEdit.roleDescription = role.description;

			$('#updateRecord').modal('show');
		},

		updateRole() {
			const vm = this;

			axios.put('/role/' + vm.selectedId, {
				name: vm.formEdit.roleName,
				description: vm.formEdit.roleDescription
			})
			.then(function (response) {
				alert(response.data.message) 
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		},

		remove() {
			const vm = this;

			axios.delete('/role/' + vm.selectedId)
			.then(function (response) {
				alert(response.data.message) 
				$('#updateRecord').modal('hide');
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		}

		// destroy(role, index) {
		// 	const vm = this;

		// 	axios.delete('/role/${role.id}')
		// 	.then(function (response) {
		// 		vm.roleList.splice(index,1);
		// 	})
		// 	.catch(function (error) {
		// 		console.log(error);
		// 	});
		// },
	}
}
</script>