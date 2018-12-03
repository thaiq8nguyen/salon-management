<template>
    <div>
        <v-toolbar>
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title>Salon Management</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn href="/home"flat :class = "{'red--text': isActiveLink('home')}" @click = "makeActiveLink('home')">Home</v-btn>
                <v-btn href="/wages/pay"flat :class = "{'red--text': isActiveLink('pay-day')}" @click = "makeActiveLink('pay-day')">Pay Day</v-btn>
                <v-btn href="/technician-sale/quick-sale-entry"flat :class = "{'red--text': isActiveLink('quick-sale-entry')}" @click = "makeActiveLink('quick-sale-entry')">Quick Sale Entry</v-btn>
                <v-menu offset-y>
                    <v-btn flat slot="activator">Reports</v-btn>
                    <v-list>
                        <v-list-tile v-for="report in reports" :key="report.title" @click="">
                            <v-list-tile-title>{{ report.title }}</v-list-tile-title>
                        </v-list-tile>
                    </v-list>

                </v-menu>
                <v-btn href="/api-dashboard" flat :class = "{'red--text': isActiveLink('api-dashboard')}" @click = "makeActiveLink('api-dashboard')">API Dashboard</v-btn>
                <v-btn href="/logout" @click="logout()" flat>Log Out</v-btn>
            </v-toolbar-items>
        </v-toolbar>
    </div>

</template>

<script>
    export default {
        name: "primary-nav-bar",
        data(){
            return{
                activeLink:null,

                reports:[
                    {title:'Technician Pay Period'},
                    {title: 'Wages'}
                ]
            }
        },
        mounted(){
            this.isActiveLink(this.activeLink = sessionStorage.getItem('activeLink'));
        },

        methods:{

            isActiveLink(link){

                return this.activeLink === link;

            },
            makeActiveLink(link){

                sessionStorage.setItem('activeLink',link);

            },
            logOut(){

                sessionStorage.clear();

            }
        }

    }
</script>

<style scoped>

</style>