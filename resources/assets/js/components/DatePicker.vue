<template>
	<div id="date-picker">
		<v-card>
			<v-card-title>
				Date Picker
			</v-card-title>
			<v-card-text>
				<v-row>
					<v-col>
						<v-btn>Previous</v-btn>
					</v-col>
					<v-col>
						<v-menu ref="menu" v-model="menu" :close-on-content-click="false" :return-value.sync="date"
						        transition="scale-transition" offset-y max-width="290px">
							<template v-slot:activator="{on}">
								<v-text-field v-model="date" label="Date" readonly v-on="on"></v-text-field>
							</template>
							<v-date-picker v-model="date" no title scrollable actions>
								<v-spacer></v-spacer>
								<v-btn @click="menu = false">Cancel</v-btn>
								<v-btn @click="$refs.menu.save(date)">OK</v-btn>
							</v-date-picker>
						</v-menu>
					</v-col>

					<v-col>
						<v-btn @click="goToNextDate">Next</v-btn>
					</v-col>
				</v-row>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
  export default {
	name: "DatePicker",
	props: [],

	data () {
	  return {
		date: new Date().toISOString().substr(0, 10),
		menu: false,
	  }

	},
	watch: {
	  date: function (val) {
		this.$emit("date", val)
	  },
	},
	methods: {
	  goToNextDate () {
		this.date = this.$moment(this.date).add(1, "days");
	    //console.log(this.$moment);
	  },
	  goToPreviousDate () {

	  },

	},

  }
</script>

<style>

</style>
