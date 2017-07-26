<template>
	<div id = "technician-header" v-if="technician.firstName !== ''">
		<v-layout row class="blue darken-2">
			<v-flex lg1>
				<v-card flat>
					<v-card-text>
						<i class = "fa fa-user fa-4x white--text"></i>
					</v-card-text>
				</v-card>

			</v-flex>
			<v-flex lg11>
				<v-card flat>
					<v-card-text>
						<h3 class = "white--text">{{ technician.firstName }}</h3>
					</v-card-text>
				</v-card>
			</v-flex>
		</v-layout>
	</div>
</template>

<script>
	export default{

        props:['technician'],


		data(){

			return{

			}
		},

		methods:{

		}
	}


</script>

<style>

</style>