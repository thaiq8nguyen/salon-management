<template>
  <div id="update-technician-modal">
    <v-dialog v-model="open">
      <v-card>
        <v-card-title>Update Technician</v-card-title>
        <ValidationObserver v-slot="{ handleSubmit }">
          <v-form @submit.prevent="handleSubmit(update)">
            <v-card-text>
              <ValidationProvider name="First Name" rules="required" v-slot="{ errors }">
                <v-text-field
                  label="First Name"
                  name="first_name"
                  type="text"
                  v-model="updating.first_name"
                ></v-text-field>
                <span>{{ errors[0] }}</span>
              </ValidationProvider>
              <ValidationProvider name="Last Name" rules="required" v-slot="{ errors }">
                <v-text-field
                  label="Last Name"
                  name="last_name"
                  type="text"
                  v-model="technician.last_name"
                ></v-text-field>
                <span>{{ errors[0] }}</span>
              </ValidationProvider>
              <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                <v-text-field label="Email" name="email" type="text" v-model="technician.email"></v-text-field>
                <span>{{ errors[0] }}</span>
              </ValidationProvider>
            </v-card-text>
            <v-card-actions>
              <v-btn @click="$emit('close')">Cancel</v-btn>
              <v-spacer></v-spacer>
              <v-btn class="info" type="submit">Update</v-btn>
            </v-card-actions>
          </v-form>
        </ValidationObserver>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    name: "UpdateTechnicianModal",
	props: ["open", "technician"],

	data () {
	  return {
		defaultTechnician: {
		  first_name: "",
		  last_name: "",
		  email: "",
		  password: ""
		},
		
		updating: this.technician
	  }

	},
	watch:{
		technician: function() {
			this.updating = this.technician;
		}
	},
	methods: {
		cancel(){
			
		},
      	update(){
			  
			  this.$store.dispatch("Technicians/updateTechnician", this.updating)
			  .then(response => {
				  
				  
				  this.$emit("close");
			  })
			  .catch(errors => {

			  })
      	}
	},

  }
</script>

<style>
</style>
