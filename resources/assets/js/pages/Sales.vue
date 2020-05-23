<template>
	<div id="sales">
		<v-content>
			<v-container>
				<v-row>
					<v-col>
						<date-picker v-on:date="setDate" ></date-picker>
					</v-col>
					<v-col>

					</v-col>
				</v-row>
			</v-container>
		</v-content>
	</div>
</template>

<script>
	import DatePicker from "Components/DatePicker"
    export default {
        name: "Sales",
        components: {DatePicker},
		props: [],

		data () {
	        return {}

		},
      computed:{
		technicians(){
		  return this.$store.getters["Technicians/technicians"];
		}
      },
        created(){
          this.$store.dispatch("Technicians/getTechnicians")
        },
		methods: {
          setDate(date){
            console.log(date)
          }
		},

    }
</script>

<style>

</style>
