<template>
	<div id="update-technician-sale-dialog">
		<v-dialog v-model="open" width="500">
			<v-card>
				<v-card-title>Update</v-card-title>
				<v-form>
					<v-card-text>
						<v-row>
							<v-col>
								<v-list-item>
									<v-list-item-title>Sale</v-list-item-title>
									<v-list-item-subtitle></v-list-item-subtitle>
								</v-list-item>
								<v-list-item>
									<v-list-item-title>Tip</v-list-item-title>
									<v-list-item-subtitle></v-list-item-subtitle>
								</v-list-item>
							</v-col>
							<v-col>
								<v-text-field label="Sale"></v-text-field>
								<v-text-field label="Tip"></v-text-field>
							</v-col>
						</v-row>
					</v-card-text>
					<v-card-actions>
						<v-btn>Update</v-btn>
					</v-card-actions>
				</v-form>

			</v-card>
		</v-dialog>
	</div>
</template>

<script>
  export default {
	name: "UpdateTechnicianSaleDialog",
    props:['open'],
	data () {
	  return {}
	},
	computed: {},
	methods: {},
  }

</script>

<style scoped>

</style>
