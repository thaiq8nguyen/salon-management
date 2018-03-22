<template>
    <div>

        <v-card>
            <v-card-title>
                <h3>OAuth Client</h3>
            </v-card-title>
            <v-card-text>
                <p v-if="items.length === 0">You have not created any OAuth clients.</p>
                <v-data-table v-else
                        :headers="headers"
                        :items="items"
                        hide-actions
                >
                    <template slot = "items" slot-scope="props">

                        <td class = "text-xs-right">{{ props.item.id}}</td>
                        <td class = "text-xs-right">{{ props.item.name}}</td>
                        <td class = "text-xs-right">{{ props.item.secret}}</td>
                        <td><v-btn color="info" @click = "edit(props.item)">Edit</v-btn></td>
                        <td><v-btn color="error " @click = "destroy(props.item)">Delete</v-btn></td>

                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-actions>
                <v-btn color="success" @click.stop="createClientDialog = true">Create New Client</v-btn>
            </v-card-actions>
        </v-card>

        <!-- Create Client Dialog -->
        <v-dialog id = "create-client-dialog" v-model="createClientDialog" max-width="500px">
            <v-card>
                <v-card-title>
                    Create Client
                </v-card-title>
                <v-card-text>
                    <v-alert type="error" :value="createForm.errors.length > 0">
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <ul>
                            <li v-for="error in createForm.errors">
                                {{ error }}
                            </li>
                        </ul>
                    </v-alert>
                    <v-form>
                        <v-text-field
                            label="Name"
                            v-model="createForm.name"
                            required
                            ></v-text-field>
                        <p>Something your user will recognize and trust.</p>
                         <v-text-field
                             label="Redirect URL"
                             v-model="createForm.redirect"
                             required
                             ></v-text-field>
                        <p>Your application's authorization callback URL.</p>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="store">Create</v-btn>
                    <v-btn @click.stop="createClientDialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <!-- Edit Client Dialog -->
        <v-dialog id = "edit-client-dialog" v-model = "editClientDialog" max-width="500px">
            <v-card>
                <v-card-title>
                    <h3>Edit Client</h3>
                </v-card-title>
                <v-card-text>
                    <v-alert type="error" :value="editForm.errors.length > 0">
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <ul>
                            <li v-for="error in editForm.errors">
                                {{ error }}
                            </li>
                        </ul>
                    </v-alert>
                    <v-form>
                        <v-form>
                            <v-text-field
                                    label="Name"
                                    v-model="editForm.name"
                                    required
                            ></v-text-field>
                            <p>Something your user will recognize and trust.</p>
                            <v-text-field
                                    label="Redirect URL"
                                    v-model="editForm.redirect"
                                    required
                            ></v-text-field>
                            <p>Your application's authorization callback URL.</p>
                        </v-form>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click.native="update">Change</v-btn>
                    <v-btn @click.stop="editClientDialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                headers:[
                    { text:'Client ID', value:'id', sortable:false},
                    { text:'Name', value:'name', sortable: false},
                    { text:'Secret', value:'secret', sortable: false},
                    { sortable: false},
                    { sortable: false},

                ],

                items: [],



                createClientDialog: false,
                editClientDialog: false,

                createForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getClients();

                /*$('#modal-create-client').on('shown.bs.modal', () => {
                    $('#create-client-name').focus();
                });*/

                /*$('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-client-name').focus();
                });*/
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                this.$axios.get('/oauth/clients')
                        .then(response => {
                            this.items = response.data;

                        });
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {

                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;
                this.editClientDialog = true;

            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm);
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form) {
                form.errors = [];

                this.$axios[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];

                        this.createClientDialog = false;

                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = this.$_.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                this.$axios.delete('/oauth/clients/' + client.id)
                        .then(response => {
                            this.getClients();
                        });
            }
        }
    }
</script>
