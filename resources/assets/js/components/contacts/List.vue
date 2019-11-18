<template>
	<div class="contact-list">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					Contact
				</div>
				<div class="card-body">
					<div class="btn-wrapper">
						<button type="button" class="btn btn-primary btn-sm" @click="newModal()">
							<i class="fa fa-plus" aria-hidden="true"></i> New
						</button>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th>ID</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
							<template v-if="!contacts">
								<tr>
									<td colspan="4" class="text-center">No Contact Available</td>
								</tr>
							</template>
							<template v-else>
								<tr v-for="contact in contacts" :key="contact.id">
									<td>{{ contact.id }}</td>
									<td>{{ contact.first_name }}</td>
									<td>{{ contact.last_name }}</td>
									<td>{{ contact.created_at }}</td>
									<td class="flex">
										<span class="pr-3">
											<router-link :to="`/contact/${contact.id}`">View</router-link>
										</span>
										<span class="pr-3">
											<button type="button" class="btn btn-primary btn-sm">
												<i class="fa fa-plus" aria-hidden="true"></i> Add more..
											</button>
										</span>
										<span class="pr-3">
											<button type="button" class="btn btn-success btn-sm" @click="editModal(contact)">
												<i class="fa fa-edit blue" aria-hidden="true"></i> Edit
											</button>
										</span>
										<span class="pr-3">
											<button type="button" class="btn btn-danger btn-sm" @click="deleteContact(contact.id)">
												<i class="fa fa-trash" aria-hidden="true"></i> Delete
											</button>
										</span>
									</td>
								</tr>	
							</template>
						</table>
					</div>
					<!-- The Modal -->
					<div class="modal" id="addNew">
						<div class="modal-dialog">
							<div class="modal-content">
								<!-- Modal Header -->
								<div class="modal-header">
									<h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
									<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Contact's Info</h5>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<form @submit.prevent="editmode ? updateContact() : createContact()">
									<!-- Modal body -->
									<div class="modal-body">
										<div class="form-group">
											<input 	type="text" 
											class="form-control" 
											:class="{ 'is-invalid': form.errors.has('first_name') }"
											v-model="form.first_name"
											name="first_name"
											placeholder="First name">
											<has-error :form="form" field="first_name"></has-error>
										</div>
										<div class="form-group">
											<input 	type="text" 
											class="form-control"
											:class="{ 'is-invalid': form.errors.has('last_name') }" 
											v-model="form.last_name"
											name="last_name"
											placeholder="Last name">
											<has-error :form="form" field="last_name"></has-error>
										</div>
									</div>
									<!-- Modal footer -->
									<div class="modal-footer">
										<button v-show="editmode" type="submit" class="btn btn-success mr-auto">
											<i class="fa fa-edit" aria-hidden="true"></i> Update
										</button>
										<button v-show="!editmode" type="submit" class="btn btn-primary mr-auto">
											<i class="fa fa-plus" aria-hidden="true"></i> Create
										</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">
											Close
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- End of the Modal -->
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				editmode: false,
				contact: {},
				form: new Form({
					id:'',
					first_name: '',
					last_name: '',
				}),
				errors: null
			}
		},		
		mounted() {
			if (this.contacts.length) {
				return;
			}
			this.$store.dispatch('getContacts');
		},
		computed: {
			contacts() {
				return this.$store.getters.contacts;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			editModal(contact){
				this.editmode = true;
				this.form.reset();
				$('#addNew').modal('show');
				this.form.fill(contact);
			},
			newModal(){
				this.editmode = false;
				this.form.reset();
				$('#addNew').modal('show');
			},
			createContact(){
				this.$Progress.start();

				this.form.post('/api/contact/create')
				.then((response)=>{
					Fire.$emit('AfterCreate');
					$('#addNew').modal('hide');
					swal.fire('Add Contact','Contact created in successfully','success');
					this.$Progress.finish();
				})
				.catch((error)=>{
					this.$Progress.fail();
				})
			},
			updateContact(){
				this.$Progress.start();
				this.form.put('/api/contact/update/'+this.form.id)
				.then(() => {
					Fire.$emit('AfterCreate');
					$('#addNew').modal('hide');
					swal.fire('Updated!','Information has been updated.','success');
					this.$Progress.finish();
				})
				.catch(() => {
					this.$Progress.fail();
				});
			},
			deleteContact(id){
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {

					if (result.value) {
						axios.post('/api/contact/delete/'+id).
						then(()=>{
							swal.fire('Deleted!','Your contact has been deleted.','success'
								)
							Fire.$emit('AfterCreate');
						}).catch(()=> {
							swal.fire("Failed!", "There was something wrong.", "warning");
						});
					}
				})
			}
		},
		created() {
			Fire.$on('AfterCreate',() => {
				this.$store.dispatch('getContacts');
			});
		}
	}
</script>

<style>
.btn-wrapper {
	text-align: right;
	margin-bottom: 20px;
}
.errors {
	background: lightcoral;
	border-radius:5px;
	padding: 21px 0 2px 0;
}
</style>