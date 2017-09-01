<template>
	<v-layout row>
		<v-flex lg2><v-chip label>Payment {{ index + 1}}</v-chip></v-flex>
		<v-flex lg2>
			<v-text-field label = "Amount" prefix="$" disabled v-model="payment.amount"></v-text-field>
		</v-flex>
		<v-flex lg2>
			<v-text-field label = "Reference"  v-model="payment.reference"></v-text-field>
		</v-flex>
		<v-flex lg2>
			<v-select
					:items="methods"
					v-model="payment.method"
					label="Method"
					single-line
					bottom
			></v-select>
			<!--<v-text-field label = "Method" v-model="payment.method"></v-text-field>-->
		</v-flex>
		<v-flex lg3>
			<v-btn @click.native="deletePayment(index)" class = "red">
				<v-icon class = "white--text">delete</v-icon></v-btn>
		</v-flex>
	</v-layout>
</template>

<script>
    export default {
        props: ['payment','index'],

        data() {
            return {
				methods:['cash','check','direct deposit']
            }
        },
        methods: {
            deletePayment(index){
                this.$emit('delete',index)
            }
        }

    }
</script>

<style>

</style>