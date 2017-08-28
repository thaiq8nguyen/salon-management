import Vue from 'vue';



const app = new Vue({
    el:'#root',
    mounted(){
        window.addEventListener('mousemove',this.activity);
        window.addEventListener('keypress', this.activity);
        this.refresh();


    },
    data:{
        formattedTime: null,
        currentTime: new Date().getTime(),
        interval:null,
    },
    methods:{

        activity(){
            this.currentTime = new Date().getTime();

        },

        refresh(){
            let date = new Date();
            if(date.getTime() - this.currentTime >= 120000){
                window.location.reload(true);
            }
            setTimeout(this.refresh,10000);

        },


    }
});