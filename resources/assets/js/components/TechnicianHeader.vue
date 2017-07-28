<template>
	<div id = "technician-header" v-if="technician.fullName !== ''">
		<v-layout row wrap class="blue darken-1">
			<v-flex lg1>
				<v-card flat>
					<v-card-title>
						<i class = "fa fa-user fa-2x white--text"></i>
					</v-card-title>
				</v-card>
			</v-flex>
			<v-flex lg11>
				<v-card flat>
					<v-card-text>
						<p class = "display-1 white--text text-lg-center">{{ technician.fullName }}</p>
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