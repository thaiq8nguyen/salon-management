<template>
	<div id="technicians">
		<p>Technicians</p>
		<v-card>
			<v-card-text>
				<v-list>
					<v-list-item v-for="(technician, index) in technicians" :key="index">
						<v-list-item-content>
							<v-list-item-title :class="{'red--text':technician.technicianId === selected}">
								{{technician.fullName}}
							</v-list-item-title>
						</v-list-item-content>
						<v-list-item-action>
							<v-btn small @click="select(technician.technicianId)">Detail</v-btn>
						</v-list-item-action>
					</v-list-item>
				</v-list>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
  export default {
	name: "Technicians",
    props:['technicians'],
	data () {
	  return {
		//selected: "",
	  }
	},
	computed: {
		selected(){
		  return this.$store.getters["Payday/selectedTechnicianId"];
		}

	},





	methods: {

	  select (technicianId) {

		this.$emit("technicianId", technicianId)

	  },

	}
	,
  }

</script>

<style scoped>

</style>
