
<template>
    <div>
        <v-card>
            <v-card-title>
                <h3>Personal Access Token</h3>
            </v-card-title>
            <v-card-text>
                <p v-if="items.length === 0"></p>
                <v-data-table v-else
                    :headers="headers"
                    :items="items"
                    hide-actions
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left">{{ props.item.name}}</td>
                        <td><v-btn color="error" @click="revoke(props.item)">Delete</v-btn></td>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-actions>
                <v-btn color="success" @click="createTokenDialog=true">Create New Token</v-btn>
            </v-card-actions>
        </v-card>

        <!--<div class = "card">
            <div class="card-body">
                <h5 class = "card-title">Personal Access Token</h5>
                <p class = "card-text" v-if="tokens.length === 0">
                    You have not created any personal access token
                </p>
                <table class="table" v-if="tokens.length > 0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="token in tokens">
                        &lt;!&ndash; Client Name &ndash;&gt;
                        <td style="vertical-align: middle;">
                            {{ token.name }}
                        </td>

                        &lt;!&ndash; Delete Button &ndash;&gt;
                        <td style="vertical-align: middle;">
                            <a href = "#" class="btn btn-danger " @click="revoke(token)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <a href = "#" class="btn btn-primary" @click="showCreateTokenForm">
                    Create New Token
                </a>

            </div>
        </div>-->
        <!-- Create Token Dialog -->
        <v-dialog id="create-token-dialog" v-model="createTokenDialog" max-width="500px">
            <v-card>
                <v-card-title>Create Token</v-card-title>
                <v-card-text>
                    <v-alert type="error" :value="form.errors.length > 0">
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <br>
                        <ul>
                            <li v-for="error in form.errors">
                                {{ error }}
                            </li>
                        </ul>
                    </v-alert>
                    <v-form>
                        <v-text-field
                            label="Name"
                            v-model="form.name"
                            required
                            ></v-text-field>
                        <div v-if="scopes.length > 0">
                            <v-checkbox
                                label="Scopes"
                                v-model="scope.id">

                            </v-checkbox>
                        </div>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="success" @click="store">Create</v-btn>
                    <v-btn @click="createTokenDialog=false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Access Token Dialog -->
        <v-dialog id = "access-token-dialog" v-model="accessTokenDialog" max-width="600px">
            <v-card>
                <v-card-title>Personal Access Token</v-card-title>
                <v-card-text>
                    <p>
                        Here is your new personal access token. This is the only time it will be shown so don't lose it!
                        You may now use this token to make API requests.
                    </p>
                    <pre style="overflow: auto;"><code style="display:block; word-wrap:normal; padding: 1rem;">{{ accessToken }}</code></pre>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="accessTokenDialog=false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Create Token Modal -->
        <!--<div class="modal fade" id="modal-create-token" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Create Token
                        </h4>
                    </div>

                    <div class="modal-body">
                        &lt;!&ndash; Form Errors &ndash;&gt;
                        <div class="alert alert-danger" v-if="form.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in form.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        &lt;!&ndash; Create Token Form &ndash;&gt;
                        <form class="form-horizontal" role="form" @submit.prevent="store">
                            &lt;!&ndash; Name &ndash;&gt;
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="create-token-name" type="text" class="form-control" name="name" v-model="form.name">
                                </div>
                            </div>

                            &lt;!&ndash; Scopes &ndash;&gt;
                            <div class="form-group" v-if="scopes.length > 0">
                                <label class="col-md-4 control-label">Scopes</label>

                                <div class="col-md-6">
                                    <div v-for="scope in scopes">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                    @click="toggleScope(scope.id)"
                                                    :checked="scopeIsAssigned(scope.id)">

                                                    {{ scope.id }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    &lt;!&ndash; Modal Actions &ndash;&gt;
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Access Token Modal -->
        <!--<div class="modal fade" id="modal-access-token" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Personal Access Token
                        </h4>
                    </div>

                    <div class="modal-body">
                        <p>
                            Here is your new personal access token. This is the only time it will be shown so don't lose it!
                            You may now use this token to make API requests.
                        </p>

                        <pre><code>{{ accessToken }}</code></pre>
                    </div>

                    &lt;!&ndash; Modal Actions &ndash;&gt;
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>-->
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
                    {text:'Name', sortable: false, value: 'name'},
                    {sortable: false}
                ],
                accessToken: null,
                createTokenDialog: false,
                accessTokenDialog: false,

                items: [],
                scopes: [],

                form: {
                    name: '',
                    scopes: [],
                    errors: []
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
                this.getTokens();
                this.getScopes();

                /*$('#modal-create-token').on('shown.bs.modal', () => {
                    $('#create-token-name').focus();
                });*/
            },

            /**
             * Get all of the personal access tokens for the user.
             */
            getTokens() {
                this.$axios.get('/oauth/personal-access-tokens')
                        .then(response => {
                            this.items = response.data;
                        });
            },

            /**
             * Get all of the available scopes.
             */
            getScopes() {
                this.$axios.get('/oauth/scopes')
                        .then(response => {
                            this.scopes = response.data;
                        });
            },

            /**
             * Create a new personal access token.
             */
            store() {
                this.accessToken = null;

                this.form.errors = [];

                this.$axios.post('/oauth/personal-access-tokens', this.form)
                        .then(response => {
                            this.form.name = '';
                            this.form.scopes = [];
                            this.form.errors = [];

                            this.items.push(response.data.token);

                            this.showAccessToken(response.data.accessToken);
                        })
                        .catch(error => {
                            console.log(error.response.data);
                            if (typeof error.response.data === 'object') {
                                this.form.errors = this.$_.flatten(_.toArray(error.response.data));
                            } else {
                                this.form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },

            /**
             * Toggle the given scope in the list of assigned scopes.
             */
            toggleScope(scope) {
                if (this.scopeIsAssigned(scope)) {
                    this.form.scopes = this.$_.reject(this.form.scopes, s => s == scope);
                } else {
                    this.form.scopes.push(scope);
                }
            },

            /**
             * Determine if the given scope has been assigned to the token.
             */
            scopeIsAssigned(scope) {
                return this.$_.indexOf(this.form.scopes, scope) >= 0;
            },

            /**
             * Show the given access token to the user.
             */
            showAccessToken(accessToken) {

                this.createTokenDialog =  false;
                this.accessTokenDialog = true;
                this.accessToken = accessToken;

            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                this.$axios.delete('/oauth/personal-access-tokens/' + token.id)
                        .then(response => {
                            this.getTokens();
                        });

            }
        }
    }
</script>
