(function ( $ ) {

	"use strict";

	/*
	* Compatibility info:
	* $.live			v1.3
	* $.ready			v1.0
	* $.ajaxSuccess		v1.0
	* $.data			v1.2.3
	* $.find			v1.0
	* $.removeClass		v1.0
	* $.addClass		v1.0
	* $.parent			v1.0
	* $.parents			v1.0
	* $.val				v1.0
	* $.trigger			v1.0
	* $.is				v1.0
	* $.attr			v1.0
	* $.after			v1.0
	*
	* jQuery v1.3 required
	* WordPress 2.8 shipped jQuery 1.3.2 => http://core.trac.wordpress.org/browser/tags/2.8/wp-includes/js/jquery/jquery.js?rev=11550
	* WordPress 2.7 shipped jQuery 1.2.6 => http://core.trac.wordpress.org/browser/tags/2.7/wp-includes/js/jquery/jquery.js?rev=10186
	*
	* Current compatibility WordPress 2.8
	*
	* @type {Object}
	*/

	var tooltipStyle = {
		border:'solid 1px #6295fb',
		background:'#fff',
		color:'#000',
		padding:'5px',
		zIndex:1E3
	};

	var UTCW = {

		activeTab:{},

		init:function () {
			$( 'input[id$=-color_none], input[id$=-color_random], input[id$=-color_set], input[id$=-color_span]' ).live( 'click', this.colorClickHandler );
			$( '.utcw-tab-button' ).live( 'click', this.tabClickHandler );
			$( '.utcw-input-taxonomy' ).live( 'click', this.taxonomyClickHandler );
			$( '.utcw-all-authors' ).live( 'click', this.allAuthorsClickHandler );
			$( '.utcw-selected-authors' ).live( 'click', this.selectedAuthorsClickHandler );
			$( '.utcw-remove-config' ).live( 'click', this.removeConfigClickHandler );

			$( document ).ready( this.initTooltip );
			$( document ).ajaxSuccess( this.ajaxSuccessHandler );

		},

		initTooltip:function () {
			$( '.utcw-help' ).wTooltip( {
				style:tooltipStyle,
				className:'utcw-tooltip'
			} );
		},

		removeConfigClickHandler:function () {
			var $this = $( this );
			var $widget = UTCW.findWidgetParent( $this );
			var $loadConfig = $widget.find( '.utcw-load-config' );
			var configToRemove = $loadConfig.val();
			var fieldName = $this.data( 'input-name' ) + '[]';
			var $removeConfigField = $( document.createElement('input') );
			$removeConfigField.attr( 'type', 'hidden' );
			$removeConfigField.attr( 'name', fieldName );
			$removeConfigField.attr( 'value', configToRemove );

			$this.after( $removeConfigField );
			$loadConfig.find( ':selected' ).remove();
		},

		allAuthorsClickHandler:function () {
			var $this = $( this );
			var $widget = UTCW.findWidgetParent( $this );
			$widget.find( '.utcw-authors' ).addClass( 'hidden' );
			$widget.find( '.utcw-author-field' ).attr( 'checked', false );
		},

		selectedAuthorsClickHandler:function () {
			var $this = $( this );
			var $widget = UTCW.findWidgetParent( $this );
			$widget.find( '.utcw-authors' ).removeClass( 'hidden' );
		},

		tabClickHandler:function () {
			var $this = $( this );

			if ( $this.data( 'id' ) === 'utcw-__i__' ) {
				return false;
			}

			$this.parent().find( '.utcw-tab-button' ).removeClass( 'utcw-active' );
			$this.addClass( 'utcw-active' );

			$this.parent().find( 'fieldset.utcw' ).addClass( 'hidden' );
			$( '#' + $this.data( 'tab' ) ).removeClass( 'hidden' );

			UTCW.activeTab[ $this.data( 'id' ) ] = $this.data( 'tab' );

			return false;
		},

		colorClickHandler:function () {

			var $set_chooser = $( 'div[id$="set_chooser"]' );
			var $span_chooser = $( 'div[id$="span_chooser"]' );
			var value = $( this ).val();

			$set_chooser.addClass( 'utcw-hidden' );
			$span_chooser.addClass( 'utcw-hidden' );

			if ( value === 'set' ) {
				$set_chooser.removeClass( 'utcw-hidden' );
			} else if ( value === 'span' ) {
				$span_chooser.removeClass( 'utcw-hidden' );
			}
		},

		findWidgetParent:function ( $element ) {
			return $element.parents( '.widget-content' );
		},

		taxonomyClickHandler:function () {

			var $this = $( this );
			var taxonomy = $this.val();
			var checked = $this.is( ':checked' );
			var $widget = UTCW.findWidgetParent( $this );
			var $target = $widget.find( '#' + taxonomy + '-terms' );

			if ( checked ) {
				$target.removeClass( 'hidden' );
			} else {
				$target.addClass( 'hidden' );
			}
		},

		ajaxSuccessHandler:function ( e, xhr, settings ) {
			UTCW.setCurrentTab.apply( UTCW, [ settings.data ] );
			UTCW.initTooltip.apply( UTCW );
		},

		setCurrentTab:function ( url ) {
			var uri = new Uri();
			var widget_id;

			uri.setQuery( decodeURI( url ) );

			if ( uri.getQueryParamValue( 'action' ) === 'save-widget' && uri.getQueryParamValue( 'id_base' ) === 'utcw' ) {
				widget_id = uri.getQueryParamValue( 'widget-id' );

				if ( this.activeTab[ widget_id ] ) {
					$( 'button[data-tab="' + this.activeTab[ widget_id ] + '"]' ).trigger( 'click' );
				}
			}
		}
	};

	UTCW.init();

}( jQuery ));