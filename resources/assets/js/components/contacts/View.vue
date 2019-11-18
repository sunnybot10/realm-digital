<template>
	<div class="col-md-6">
		<div class="card card-default">
			<div class="card-header">
				{{ customer.first_name}} {{ customer.last_name}}
			</div>
			<div class="card-body">
				<div class="customerView">
					<div class="user-img">
						<img src="https://www.scottsdaleazestateplanning.com/wp-content/uploads/2018/01/user.png" alt="profile photo" />
					</div>
					<div class="user-info">
						<table class="table">
							<tr>
								<td>ID</td>
								<td>{{ customer.id}}</td>
							</tr>
							<tr>
								<td>First name</td>
								<td>{{ customer.first_name}}</td>
							</tr>
							<tr>
								<td>Last name</td>
								<td>{{ customer.last_name}}</td>
							</tr>
							<tr>
								<td>Date Created</td>
								<td>{{ customer.created_at}}</td>
							</tr>
							<tr>
								<td>Date Updated</td>
								<td>{{ customer.updated_at}}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'customerView',
		data() {
			return {
				customer: {}
			};
		},
		created() {
			if (this.customers.length) {
				this.customer = this.customers.find((customer) => customer.id == this.$route.params.id);
			} else {
				axios.get(`/api/customer/show/${this.$route.params.id}`)
				.then((response) => {
					this.customer = response.data.customer
				});
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			customers() {
				return this.$store.getters.customers;
			}
		}
	}
</script>

<style scoped>
.customer-view {
	display: flex;
	align-items: center;
}
.user-img {
	flex: 1;
}
.user-img img {
	max-width: 160px;
}
.user-info {
	flex: 3;
}
</style>