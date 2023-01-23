(function( $, JetEngineTablesListConfig ) {

	'use strict';

	window.JetEngineTablesList = new Vue( {
		el: '#jet_tables_list',
		template: '#jet-tables-list',
		data: {
			itemsList: [],
			errorNotices: [],
			editLink: JetEngineTablesListConfig.edit_link,
			queries: JetEngineTablesListConfig.queries,
			showDeleteDialog: false,
			deletedItem: {},
		},
		mounted() {

			var params = new URLSearchParams();

			params.append( 'instance', JetEngineTablesListConfig.instance );

			wp.apiFetch( {
				method: 'get',
				path: JetEngineTablesListConfig.api_path + '?' + params.toString(),
			} ).then( ( response ) => {

				console.log( response );

				if ( response.success && response.data ) {
					for ( var itemID in response.data ) {
						var item = response.data[ itemID ];
						this.itemsList.push( item );
					}
				} else {
					this.$CXNotice.add( {
						message: response.message,
						type: 'error',
						duration: 15000,
					} );
				}
			} ).catch( ( e ) => {
				this.$CXNotice.add( {
					message: e.message,
					type: 'error',
					duration: 15000,
				} );
			} );
		},
		methods: {
			deleteItem( item ) {
				this.deletedItem      = item;
				this.showDeleteDialog = true;
			},
			getEditLink( id ) {
				return this.editLink.replace( /%id%/, id );
			},
			queryLabel( id ) {
				var qLabel = this.queries[ id ] || id;
				return qLabel;
			},
		}
	} );

})( jQuery, window.JetEngineTablesListConfig );
