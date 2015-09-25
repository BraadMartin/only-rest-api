module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		wp_readme_to_markdown: {
			your_target: {
				files: {
					'readme.md': 'readme.txt'
				}
			}
		},
		makepot: {
			target: {
				options: {
					type: 'wp-plugin'
				}
			}
		}
	});

	// Load the plugins that provides the uglify and minify tasks.
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	// Default task(s).
	grunt.registerTask( 'build', [
		'wp_readme_to_markdown',
		'makepot'
	] );

};