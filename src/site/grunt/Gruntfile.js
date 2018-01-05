'use strict';

module.exports = function(grunt) {
	// Project configuration.
	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),

		// grunt-contrib-concatの設定（ファイル結合）
		concat: {
			js : {
				src: ['../htdocs/assets/jquery.min.js', '../htdocs/assets/libs/*.js', '../htdocs/assets/views/*.js'],
				dest : '../htdocs/assets/dest/all.js'
			},
			js_sp : {
				src: ['../htdocs/assets/sp/jquery.library.js', '../htdocs/assets/sp/libs/*.js', '../htdocs/assets/sp/views/*.js'],
				dest : '../htdocs/assets/sp/dest/all.js'
			},

			css : {
				src: ['../htdocs/assets/style.css', '../htdocs/assets/libs/*.css'],
				dest: '../htdocs/assets/dest/all.css'
			},
			css_sp : {
				src: ['../htdocs/assets/sp/style.css', '../htdocs/assets/sp/libs/*.css'],
				dest: '../htdocs/assets/sp/dest/all.css'
			}
		},

		// grunt-contrib-cssminの設定（css、minify）
		cssmin : {
			minify: {
				expand: true,
				src : ['../htdocs/assets/dest/all.css'],
				dest : '',
				ext: '.min.css'
			},
			minify_sp: {
				expand: true,
				src : ['../htdocs/assets/sp/dest/all.css'],
				dest : '',
				ext: '.min.css'
			}
		},

		// grunt-contrib-uglifyの設定（js、minifyと難読化）
		uglify : {
			options : {
				// true にすると難読化がかかる。false だと関数や変数の名前はそのまま
				mangle : true
			},
			my_target : {
				files : {
					'../htdocs/assets/dest/all.min.js' : ['../htdocs/assets/dest/all.js']
				}
			},
			my_target_sp : {
				files : {
					'../htdocs/assets/sp/dest/all.min.js' : ['../htdocs/assets/sp/dest/all.js']
				}
			}
		},

		// grunt-contrib-compressの設定（圧縮）
		compress : {
			js: {
				options : {
					mode: 'gzip'
				},
				files : [{
					expand: true,
					src : ['../htdocs/assets/dest/all.min.js'],
					dest: '',
					ext: '.js.gz'
				}]
			},
			js_sp: {
				options : {
					mode: 'gzip'
				},
				files : [{
					expand: true,
					src : ['../htdocs/assets/sp/dest/all.min.js'],
					dest: '',
					ext: '.js.gz'
				}]
			},

			css: {
				options : {
					mode: 'gzip'
				},
				files : [{
					expand: true,
					src : ['../htdocs/assets/dest/all.min.css'],
					dest: '',
					ext: '.css.gz'
				}]
			},
			css_sp: {
				options : {
					mode: 'gzip'
				},
				files : [{
					expand: true,
					src : ['../htdocs/assets/sp/dest/all.min.css'],
					dest: '',
					ext: '.css.gz'
				}]
			}
		},

		// grunt-contrib-watchの設定(ウォッチ対象の設定)
		watch : {
			tpl_files : {
				files : '../app/views/templates/**/*.tpl'
			},
			// js_files : {
			// 	files : '../htdocs/assets/**/*.js',
			// 	tasks : ['concat:js', 'uglify', 'compress:js']
			// },
			// css_files : {
			// 	files : '../htdocs/assets/**/*.css',
			// 	tasks : ['concat:css', 'cssmin', 'compress:css']
			// },
			options : {
				hostname: '*',
				port : '*',
				livereload : true,
			}
		}

	});

	// Load tasks(grunt実行時に読み込むプラグイン)
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compress');

	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default tasks(grunt実行時に実行するタスク)
	grunt.registerTask('default', ['concat', 'cssmin', 'uglify', 'compress']);

	// grunt auto_watch など引数を与えると実行されるタスク
	grunt.registerTask('auto_watch', ['watch']);

};