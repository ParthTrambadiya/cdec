module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			scripts: {
				files: ['js/*.js', '!js/*.min.js'],
				tasks: ['jshint']
			}
		},
		jshint: {
			src: ['js/*.js', '!js/*.min.js']
		},
		uglify: {
			options: {
				compress: {
					drop_console: true
				},
				output: {
					comments: 'all'
				}
			},
			js: {
				files: [{
					cwd: 'js/src/',
					expand: true,
					src: '*.js',
					dest: 'js/'
				}]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default', ['watch']);
	grunt.registerTask('minify', ['uglify']);

};
