<template>
  <v-app>
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Login</v-toolbar-title>
              </v-toolbar>
              <ValidationObserver v-slot="{ handleSubmit }">
                <v-form @submit.prevent="handleSubmit(login)">
                  <v-card-text>
                    <ValidationProvider
                      name="email"
                      rules="required|email"
                      v-slot="{ errors }"
                    >
                      <v-text-field
                        label="Email"
                        name="email"
                        type="email"
                        v-model="credential.email"
                      ></v-text-field>
                      <span>{{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider
                      name="password"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <v-text-field
                        label="Password"
                        name="password"
                        type="password"
                        v-model="credential.password"
                      ></v-text-field>
                      <span>{{ errors[0] }}</span>
                    </ValidationProvider>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="info" type="submit">Login</v-btn>
                  </v-card-actions>
                </v-form>
              </ValidationObserver>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      credential: {
        email: "",
        password: ""
      },
      authenticationErrors: "",
      isAuthenticating: ""
    };
  },
  computed: {},
  mounted() {
    console.log("Loging is mounted");
  },
  methods: {
    login() {
      this.$store
        .dispatch("Authentications/login", this.credential)
        .then(() => {});
    }
  }
};
</script>

<style lang="scss" scoped></style>
