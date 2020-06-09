<template>
	<div id="date-picker">

		<v-card>

			<v-card-text>
				<v-row align="center">
					<v-col class="d-flex justify-start" md="3">
						<v-icon @click="goToPreviousDate">mdi-arrow-left</v-icon>
					</v-col>
					<v-col class="d-flex justify-center" md="6">
						<v-menu ref="menu" v-model="menu" :close-on-content-click="false" :return-value.sync="date"
						        transition="scale-transition" offset-y max-width="290px">
							<template v-slot:activator="{on}">
								<v-text-field v-model="formattedDate" label="Date" readonly v-on="on"></v-text-field>
							</template>
							<v-date-picker v-model="date" no title scrollable actions>
								<v-spacer></v-spacer>
								<v-btn @click="menu = false">Cancel</v-btn>
								<v-btn @click="$refs.menu.save(date)">OK</v-btn>
							</v-date-picker>
						</v-menu>
					</v-col>

					<v-col class="d-flex justify-end" md="3">
						<v-icon @click="goToNextDate">mdi-arrow-right</v-icon>
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
    computed:{
	    formattedDate (){
	      return this.$moment(this.date).format("ddd, MM/DD/YYYY");
	    }
    },

	watch: {
	  date: function (val) {
		this.$emit("date", this.$moment(val).format("YYYY-MM-DD"))
	  },
	},
	methods: {
	  goToNextDate () {
		this.date = this.$moment(this.date).add(1, "days");

	  },
	  goToPreviousDate () {
		this.date = this.$moment(this.date).subtract(1, "days");
	  },

	},

  }
</script>

<style>

</style>
