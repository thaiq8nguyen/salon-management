<template>
	<div>
		<v-layout>
			<v-flex lg8 md8>
				<v-text-field prepend-icon="search" v-model="parameter"
				              label="Search Gift Certificate" @keyup.enter="search" id="search-input"></v-text-field>
			</v-flex>
			<v-flex lg4 md4>
				<v-btn @click.native="search" primary>Search</v-btn>
			</v-flex>
		</v-layout>

		<v-dialog v-model="showDialog" width="640">
			<v-card v-show="showSearching">
				<v-card-text>
					<h3>Searching certificates...</h3>
				</v-card-text>
			</v-card>
			<v-card v-show="showSearchById">
				<v-card-text>
					<v-list two-line >
						<template v-for="(result,index) in results">
							<v-list-tile :key="index" @click.native="select(index)">
								<v-list-tile-avatar>
									<v-icon class large>card_giftcard</v-icon>
								</v-list-tile-avatar>
								<v-list-tile-content>
									<v-list-tile v-html=" giftStatus(index)"></v-list-tile>
									<v-list-tile-sub-title>
										<v-layout row wrap class="subheading">
											<v-flex lg3>
												<p>ID: {{ result.squareId.substring(0,5) }}</p>
											</v-flex>
											<v-flex lg4>
												Amount: $ {{ result.amount }}
											</v-flex>
											<v-flex lg4>
												Expired: {{ readableDate(result.expired_at) }}
											</v-flex>
										</v-layout>
									</v-list-tile-sub-title>
								</v-list-tile-content>
							</v-list-tile>
							<v-divider></v-divider>
						</template>
					</v-list>
					<v-btn @click.native="showDialog = false">Close</v-btn>
				</v-card-text>
			</v-card>
			<v-card v-show="showSearchByDate">
				<v-card-text>
					<v-layout row>
						<v-flex lg6 md6>
							<v-date-picker v-model="date"></v-date-picker>
						</v-flex>
						<v-flex lg6 md6>
							<p class = "title text-xs-center">Please select the date the certificate was sold on the left.</p>
						</v-flex>
					</v-layout>
				</v-card-text>
			</v-card>
			<v-card v-show="noResultsFound">
				<v-card-text>
					<v-alert warning value="true" class = "title">No Certificates Found</v-alert>
					<v-divider></v-divider>
					<v-btn @click.native="showDialog = false">Close</v-btn>
				</v-card-text>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
    export default {
        props: [],

        data() {
            return {
                parameter: null,
	            results: null,
	            showDialog: false,
	            showSearchById: false,
	            showSearchByDate:false,
	            noResultsFound: false,
	            showSearching:false,
	            date:null,
            }

        },
	    watch:{
		    date(){
		        this.searchByDate();
		    }
	    },

        methods: {
            search(){
				if(this.parameter){
					this.results = null;
					this.showSearchById = false;
					this.showSearchByDate = false;
					this.noResultsFound = false;
					this.showSearching = true;
                    this.$axios.get('/api/gift-certificate/search?squareId=' + this.parameter).then(response => {

                        this.showDialog =true;
                        if(response.data.length > 0){
                            this.results = response.data;
                            this.showSearching = false;
                            this.showSearchById = true;
                            this.parameter = null;
                        }
                        else{
                            this.showSearchById = false;
                            this.showSearchByDate = true;
                        }
                    });
				}

            },

	        searchByDate(){
                this.showSearching = true;
                this.$axios.get('/api/gift-certificate/search?squareId= ' + this.parameter + '&date=' + this.date).then(response => {

                    if(response.data.length > 0){
                        this.results = response.data;
                        this.showSearching = false;
						this.showSearchByDate = false;
						this.showSearchById = true;
                    }
                    else{
                        this.showSearching = false;
                        this.showSearchByDate = false;
                        this.noResultsFound = true;
                    }

                });
	        },
	        giftStatus(index){
                let keyword = '';
                if(parseFloat(this.results[index].amount) > 0 && this.$moment(this.results[index].expired_at) >= this.$moment()){
                    this.results[index].selectable  = true;
					keyword = '<span class = "green--text text-darken-1 headline">Active</span>';
                }
                else if(parseFloat(this.results[index].amount) === 0){
                    this.results[index].selectable  = false;
                    keyword ='<span class = "red--text text-darken-1 headline">Zero Value</span>';
                }
                else if(this.$moment(this.results[index].expired_at) < this.$moment()){
                    this.results[index].selectable = false;
                    keyword = '<span class = "red--text text-darken-1 headline">Expired</span>';
                }

                return keyword;
	        },
	        select(index){
	            this.parameter = null;

	            if(this.results[index].selectable){
                    this.showDialog = false;
                    this.$emit('selected',this.results[index]);
	            }


	        },
	        readableDate(date){
	            return this.$moment(date).format('MM/DD/YYYY');
	        }
        }


    }
</script>

<style>
	#search-input{
		font-size:36px;
	}
</style>