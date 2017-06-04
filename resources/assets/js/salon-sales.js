import Datepicker from 'vuejs-datepicker';

Vue.component('datepicker',Datepicker);

let app = new Vue({
    el: '#root',

    data:{
        //datepicker properties
        bootstrapStyling:true,
        date: new Date(),
        dateFormat: 'MM/dd/yyyy',

        //table properties
        sqGrossSales:'$1001'
    },
    mounted(){
      console.log('alert');
    },

    methods:{

    }
});