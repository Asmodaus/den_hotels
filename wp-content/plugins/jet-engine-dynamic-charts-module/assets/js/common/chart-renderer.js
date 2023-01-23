/**
 * Cart renderer class
 */

"use strict";

var JetChartRenderer = function JetChartRenderer( chartData, chartConfig, $target, locale ) {

	$target = $target || null;
	locale  = locale || window.JetChartLocale || false;

	var chart   = null;
	var dataSet = {};

	if ( $target && $target.dataset ) {
		dataSet = $target.dataset;
	}

	const config = chartConfig || JSON.parse( dataSet.config ) || {};
	const data   = chartData || JSON.parse( dataSet.data ) || [];

	var options = config;

	const drawChart = function() {

		var chartData = window.google.visualization.arrayToDataTable( data );
		var view      = new window.google.visualization.DataView( chartData );

		if ( ! config.type ) {
			throw 'Chart type is not defined';
		}

		switch ( config.type ) {
			case 'bar':
				chart = new google.charts.Bar( $target );
				options = google.charts.Bar.convertOptions( options );
				break;

			case 'line':
				chart = new google.charts.Line( $target );
				options = google.charts.Line.convertOptions( options );
				break;

			case 'area':
				chart = new google.visualization.AreaChart( $target );
				break;

			case 'pie':
				chart = new google.visualization.PieChart( $target );
				break;

			case 'donut':
				chart = new google.visualization.PieChart( $target );
				options.pieHole = 0.4;
				break;

			case 'bubble':
				chart = new google.visualization.BubbleChart( $target );
				break;

			case 'steppedarea':
				chart = new google.visualization.SteppedAreaChart( $target );
				break;

			case 'candlestick':
				chart = new google.visualization.CandlestickChart( $target );
				break;

			case 'histogram':
				chart = new google.visualization.Histogram( $target );
				break;

			case 'columns':
				chart = new google.visualization.ColumnChart( $target );
				break;

			case 'scatter':
				chart = new google.visualization.ScatterChart( $target );
				break;

			case 'geo':
				chart = new google.visualization.GeoChart( $target );
				delete( options.maps_api_key );
				break;
		}

		if ( options.type ) {
			delete( options.type );
		}

		if ( chart ) {
			try {
				chart.draw( chartData, options );
			} catch ( error ) {
				$target.innerHTML = error;
			}
		} else {
			throw 'Chart type not found';
		}

	}

	this.reDraw= function( newData ) {

		var chartData = window.google.visualization.arrayToDataTable( newData );
		var view      = new window.google.visualization.DataView( chartData );

		if ( chart ) {
			chart.draw( view, options );
		}

	}

	this.initChart = function() {

		if ( ! config.type ) {
			throw 'Chart type is not defined';
		}

		var loadConfig = {};

		switch ( config.type ) {
			case 'geo':

				if ( ! config.maps_api_key ) {
					throw 'Google maps API key is missing for Geo chart';
				}

				loadConfig = {
					'packages':['geochart'],
					'mapsApiKey': config.maps_api_key,
				};

				break;

			case 'bar':
			case 'line':

				loadConfig = {
					'packages': [ 'corechart', config.type ],
				};

				break;

			default:

				loadConfig = {
					'packages': [ 'corechart' ],
				};

				break;
		}

		if ( locale ) {
			loadConfig.language = locale;
		}

		window.google.charts.load( 'current', loadConfig );
		window.google.charts.setOnLoadCallback( drawChart );

	};

}

window.JetChartRenderer = JetChartRenderer;

( function( $ ) {

	function initializeElementor() {
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/jet-dynamic-chart.default',
			initializeElementorChart
		);
	}

	function initializeChart( chartEl ) {

		if ( chartEl.dataset.initialized ) {
			return;
		}

		var chart = new JetChartRenderer( null, null, chartEl );
		chart.initChart();

		chartEl.dataset.initialized = true;

		$( chartEl ).on( 'jet-filter-data-updated', function( event, response ) {
			chart.reDraw( response.chartData );
		} );

	}

	function initializeElementorChart( $scope ) {
		var $chart = $scope.find( '.jet-engine-chart' );
		initializeChart( $chart[0] );
	}

	// Initialize charts found on the page
	const jetChartsList = document.querySelectorAll( '.jet-engine-chart' );

	jetChartsList.forEach( function( chart ) {
		initializeChart( chart );
	});

	// Initialize Elementor charts
	$( window ).on( 'elementor/frontend/init', initializeElementor );

}( jQuery ) );
