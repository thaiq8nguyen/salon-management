<template>
    <v-card>
        <v-card-text>
            <v-layout>
                <v-flex>
                    <v-btn color="info" @click.native="previousDate(date)">
                        <v-icon>keyboard_arrow_left</v-icon>
                        Previous Date
                    </v-btn>
                </v-flex>
                <v-flex>
                    <v-menu
                            lazy
                            :close-on-content-click="true"
                            v-model="datePicker"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-left="0"
                            max-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                label="Select a sale date"
                                v-model="date"
                                readonly
                        ></v-text-field>
                        <v-date-picker v-model="date" no-title scrollable actions ></v-date-picker>
                    </v-menu>
                </v-flex>
                <v-flex>
                    <v-btn color="info" @click.native="nextDate(date)">
                        Next Date
                        <v-icon>keyboard_arrow_right</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-card-text>
    </v-card>
</template>

<script>

    export default {
        name: "calendar",
        data: function (){
            return{
                datePicker: false,
                date: this.$moment().format('YYYY-MM-DD'),
            }
        },

        mounted(){
            this.emitDate();
        },
        watch:{
            date(){
                this.emitDate();
            }
        },



        methods:{
            previousDate(date){
                this.date = this.$moment(date).subtract(1,'days').format('YYYY-MM-DD');
            },
            nextDate(date){
                this.date = this.$moment(date).add(1,'days').format('YYYY-MM-DD');
            },
            emitDate(){
                this.$emit('selectedDate', this.date);
            }
        }
    }


</script>

<style scoped>

</style>