module.exports = function(grunt) {
  grunt.initConfig({


    pkg: grunt.file.readJSON('package.json'),
	
	
	
    sass: {
      options: {
		sourceMap: true
      },
      dist: {
        options: {
          //outputStyle: 'compressed'
		  outputStyle: 'compact'
        },
        files: {
          'css/main.css': 'scss/style.scss',
          'css/woocommerce.css': 'scss/woocommerce.scss',
          'css/app.css': 'scss/app.scss'
        }
      }
    },




    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: ['scss/*.scss'],
		tasks: ['sass'],
		options: {
			spawn: false
		}
      }
    },
	


	
	browserSync: {
		dev: {
			bsFiles: {
				src : ['css/*.css']
			},
			options: {
				watchTask: true
			}
		}
	}
	
	
	 
	
  });


	// load npm tasks (faster via jit-grunt)
	require('jit-grunt')(grunt);

	grunt.registerTask('default', ['sass', 'browserSync', 'watch']);
}