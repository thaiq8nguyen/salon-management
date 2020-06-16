<template>
	<div id="payment">
		<v-row align="center">
			<v-col>
				<v-text-field
						label="Payment " v-model.number="payment.amount"></v-text-field>
			</v-col>
			<v-col>
				<v-select :items="paymentMethods" label="Method" item-text="name"
				          item-value="id" v-model="payment.method"></v-select>
			</v-col>
			<v-col>
				<v-text-field label="Ref" v-model="payment.reference"></v-text-field>
			</v-col>
			<v-col>
				<v-btn @click="addPayment" small>Add Payment</v-btn>
			</v-col>
		</v-row>
	</div>
</template>

<script>
  export default {
	name: "Payment",
    props:["paymentMethods"],
	data () {
	  return {
	    default:{
		  amount: "",
		  method: "",
		  reference: ""
	    },
	    payment: {
		  amount: "",
		  method: "",
		  reference: ""
	    }

	  }
	},
	computed: {

	},
	methods: {
	  addPayment(){
	    this.$emit("payment", this.payment );
	    this.payment = Object.assign({}, this.default);
	  }
	},
  }

</script>

<style scoped>

</style>
