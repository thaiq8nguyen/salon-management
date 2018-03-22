<template>
    <div>
        <v-app id = "api-dashboard-app">
            <primary-nav-bar></primary-nav-bar>
            <v-container grid-list-lg text-lg-center>

                <v-layout row wrap>
                    <v-flex lg6>
                        <clients></clients>
                    </v-flex>
                    <v-flex lg6>
                        <personal-access-tokens></personal-access-tokens>
                    </v-flex>
                </v-layout>

            </v-container>
        </v-app>
    </div>
</template>

<script>
    import PrimaryNavBar from './PrimaryNavBar';
    import Clients from '../passport/Clients';
    import PersonalAccessTokens from '../passport/PersonalAccessTokens';

    export default {
        name: "api-dashboard",
        components:{PrimaryNavBar, Clients, PersonalAccessTokens}
    }
</script>

<style scoped>

</style>