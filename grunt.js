/*global module:false*/
module.exports = function ( grunt ) {

	// Project configuration.
	grunt.initConfig( {
		meta:{
			version:'2.2.3',
			banner:'/*! Ultimate Tag Cloud Widget - v<%= meta.version %> - ' +
				'<%= grunt.template.today("yyyy-mm-dd") %>\n' +
				'* https://0x539.se/wordpress/ultimate-tag-cloud-widget/\n' +
				'* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
				'Rickard Andersson; Licensed GPLv2 */'
		},
		lint:{
			files:['grunt.js', 'js/utcw.js']
		},
		min:{
			dist:{
				src:['<banner:meta.banner>', 'js/lib/*', 'js/utcw.js' ],
				dest:'js/utcw.min.js'
			}
		},
		watch:{
			files:'<config:lint.files>',
			tasks:'lint qunit'
		},
		jshint:{
			options:{
				curly:true,
				eqeqeq:true,
				immed:true,
				latedef:true,
				newcap:true,
				noarg:true,
				sub:true,
				undef:true,
				boss:true,
				eqnull:true,
				browser:true
			},
			globals:{
				jQuery:true,
				Uri:true,
                ajaxurl:true
			}
		},
		uglify:{}
	} );

	// Default task.
	grunt.registerTask( 'default', 'lint min' );

};
