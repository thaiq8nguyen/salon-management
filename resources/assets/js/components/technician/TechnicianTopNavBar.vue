<template>
	<v-toolbar class = "white" id = "top-nav-bar">
		<v-menu offset-y id = "top-nav-bar-menu">
			<v-btn icon slot="activator">
				<v-icon>menu</v-icon>
			</v-btn>
			<v-list :style="{width:allowedWidth}">
				<template v-for="item in menu" >
					<v-divider v-if="item.divider"></v-divider>
					<v-list-tile @click="navigate(item.link)">
						<v-list-tile-title :class="item.format">
							<v-icon>{{item.icon}}</v-icon>&nbsp;
							{{item.title }}
						</v-list-tile-title>
					</v-list-tile>
				</template>

			</v-list>
		</v-menu>
	</v-toolbar>
</template>

<script>
    export default {
        props: [],

        data() {
            return {
	            menu:[
		            {title: 'Home', link: '/technician', format:'', icon: 'home', divider: false},
                    {title: 'Sale', link: '/technician/sale', format:'', icon: 'attach_money', divider: false},
                    {title: 'Report', link: '/technician/reports/payment-reports', format:'', icon: 'content_paste', divider: false},
                    {title: 'Log Out', link: '/logout', format:'red--text', icon: 'exit_to_app', divider: true}
	            ],

	            maxWidth: window.innerWidth,
            }


        },
	    computed:{
            allowedWidth(){
                return (this.maxWidth * 0.6) + 'px';
            }
	    },
        methods: {
			navigate(link){
			    location.href = link;
			}
        }


    }
</script>

<style>

</style>