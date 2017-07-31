<template>
	<div>
		<template v-if="name !== null">
			<v-layout class="blue darken-1">
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
							<p class = "display-1 white--text text-lg-center">{{ name }}</p>
						</v-card-text>
					</v-card>
				</v-flex>
			</v-layout>
		</template>

	</div>
</template>

<script>
	export default{
        props:['fullName'],

		data(){
			return{
				name:null,
			}
		},

		watch:{
		    fullName(){
		        if(this.fullName !== null){
		            this.name = this.fullName;
		        }else{
		            this.name = null;
		        }
		    }
		},
		methods:{
		}
	}
</script>

<style>

</style>