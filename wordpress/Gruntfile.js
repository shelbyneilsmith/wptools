module.exports = function(grunt) {
	// Project configuration.
	grunt.initConfig({
		projectID: '',
		projectDir: '~/sites/<%= projectID %>',
		assetsDir: 'wp-content/themes/yb/assets',
		// let us know if our JS is sound
		jshint: {
			options: {
				"bitwise": true,
				"browser": true,
				"curly": true,
				"eqeqeq": true,
				"eqnull": true,
				"esnext": true,
				"immed": true,
				"jquery": true,
				"latedef": true,
				"newcap": true,
				"noarg": true,
				"node": true,
				"strict": false,
				"trailing": true,
				"undef": true,
				"globals": {
					"jQuery": true,
					"alert": true,
					"Modernizr": true,
					"MyAjax": true,
					"G_vmlCanvasManager": true,
					"WebFontConfig": true
				}
			},
			all: [
				'Gruntfile.js',
				'<%= assetsDir %>/scripts/source/*.js'
			]
		},

		// concatenation and minification all in one
		uglify: {
			files: {
				src: '<%= assetsDir %>/scripts/source/*.js',
				dest: '<%= assetsDir %>/scripts/build/',
				expand: true,
				flatten: true,
				ext: '.min.js'
			}
      		},
		concurrent: {
			watch: {
				tasks: ['browserSync', 'watch', 'compass:watch'],
				options: {
					logConcurrentOutput: true
				}
			}
		},
      		// style (Sass) compilation via Compass
		compass: {
			watch: {
				options: {
					sassDir: '<%= assetsDir %>/styles/scss',
					cssDir: '<%= assetsDir %>/styles/css',
					imagesDir: '<%= assetsDir %>/images',
					images: '<%= assetsDir %>/images',
					javascriptsDir: '<%= assetsDir %>/scripts/build',
					fontsDir: '<%= assetsDir %>/fonts',
					outputStyle: 'expanded',
					watch: true
				}
			},
			compile: {
				options: {
					sassDir: '<%= assetsDir %>/styles/scss',
					cssDir: '<%= assetsDir %>/styles/css',
					imagesDir: '<%= assetsDir %>/images',
					images: '<%= assetsDir %>/images',
					javascriptsDir: '<%= assetsDir %>/scripts/build',
					fontsDir: '<%= assetsDir %>/fonts',
					environment: 'production',
					outputStyle: 'compressed',
					relativeAssets: true,
					noLineComments: true,
					force: true,
				}
			}
		},

		imagemin: {
			dist: {
				options: {
					optimizationLevel: 3
				},
				files: [
					{
						expand: true,
						cwd: '<%= assetsDir %>/images/',
						src: ['<%= assetsDir %>/images/*.jpg'],
						dest: '<%= assetsDir %>/images/',
						ext: '.jpg'
					},
					{
						expand: true,
						cwd: '<%= assetsDir %>/images/',
						src: ['<%= assetsDir %>/images/*.png'],
						dest: '<%= assetsDir %>/images/',
						ext: '.png'
					}
				]
			}
		},
    		// watch our project for changes
		watch: {
			js: {
				files: [
					'<%= jshint.all %>'
				],
				tasks: ['jshint', 'uglify'],
				options: {
					spawn: false,
				},
			}
		},
		browserSync: {
			files: {
				src : [
					'<%= assetsDir %>/styles/css/*.css',
					'<%= assetsDir %>/scripts/source/*.js',
					'wp-content/themes/yb/*.php'
				]
			},
			options: {
				watchTask: true,
				open: false,
				proxy: "<%= projectID %>.localdev",
				ghostMode: {
					clicks: true,
					forms: true,
					scroll: false
				}
			}
		},
  	});

	// load tasks
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-concurrent');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-contrib-imagemin');


	// register task
	grunt.registerTask('default', [ 'concurrent:watch' ]);
	grunt.registerTask('build', [ 'jshint', 'uglify', 'imagemin' ]);
};