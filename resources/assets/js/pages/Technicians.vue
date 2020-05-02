<template>
  <div id="technician-page">
    <v-content>
      <v-container fluid>
        <v-row>
          <v-col>
            <v-card>
              <v-card-title class="info white--text">Add New Technician</v-card-title>
              <ValidationObserver v-slot="{ handleSubmit }">
                <v-form @submit.prevent="handleSubmit(add)">
                  <v-card-text>
                    <ValidationProvider name="First Name" rules="required" v-slot="{ errors }">
                      <v-text-field
                        label="First Name"
                        name="first_name"
                        type="text"
                        v-model="technician.first_name"
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
                      <v-text-field
                        label="Email"
                        name="email"
                        type="text"
                        v-model="technician.email"
                      ></v-text-field>
                      <span>{{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Password" rules="required" v-slot="{ errors }">
                      <v-text-field
                        label="Password"
                        name="password"
                        type="text"
                        v-model="technician.password"
                      ></v-text-field>
                      <span>{{ errors[0] }}</span>
                    </ValidationProvider>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="info" type="submit">Add</v-btn>
                  </v-card-actions>
                </v-form>
              </ValidationObserver>
            </v-card>
          </v-col>
          <v-col>
            <v-card>
              <v-card-title>Technicians</v-card-title>
              <v-card-text>
                <v-list>
                  <v-list-item v-for="technician in technicians" :key="technician.id">
                    <v-list-item-content>{{`${technician.first_name} ${technician.last_name}`}}</v-list-item-content>
                    <v-list-item-action>
                      <v-btn small @click="handleUpdateTechnicianModal(technician.id)">Update</v-btn>
                    </v-list-item-action>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
    <update-technician-modal
      :open="updateTechnicianModal"
      v-on:close="updateTechnicianModal=false"
      :technician="updatingTechnician"
    ></update-technician-modal>
  </div>
</template>

<script>
  import UpdateTechnicianModal from "Components/UpdateTechnicianModal"

  export default {
	name: "Technicians",
	components: {UpdateTechnicianModal},
	props: [],

	data () {
	  return {
		defaultTechnician: {
		  first_name: "",
		  last_name: "",
		  email: "",
		  password: "",
		},
		technician: {
		  first_name: "Thai",
		  last_name: "",
		  email: "",
		  password: "",
		},
	    updatingTechnician: "",

	    updateTechnicianModal: false,


	  }

	},
	computed: {
	  technicians () {
		return this.$store.getters["Technicians/technicians"]
	  },

	},
	mounted () {
	  this.$store.dispatch("Technicians/getTechnicians")
	},
	methods: {
	  handleUpdateTechnicianModal(id){

		this.updatingTechnician = this.technicians.find(technician => technician.id === id);
		this.updateTechnicianModal = true;
	  },

	  add () {
		this.$store.dispatch("Technicians/addTechnician", this.technician).then(() => {
		  this.technician = Object.assign({}, this.defaultTechnician)
		})
	  },
	},

  }
</script>

<style>
</style>
