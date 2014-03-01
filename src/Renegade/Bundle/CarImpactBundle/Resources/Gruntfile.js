module.exports = function (grunt) {
    'use strict';
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        jshint: {
            files: ['Gruntfile.js', 'assets/js/**/*.js'],
            options: {
                undef: true,
                globals: {
                    module: true,
                    jQuery: true
                }
            }
        },
        compass: {
            dev: {
                options: {
                    config: 'config.rb',
                    noLineComments: false,
                    outputStyle: 'expanded',
                    bundleExec: true,
                    force: true
                }
            },
            dist: {
                options: {
                    config: 'config.rb',
                    noLineComments: true,
                    outputStyle: 'compressed',
                    force: true,
                    bundleExec: true
                }
            }
        },
        watch: {
            scripts: {
                files: ['Gruntfile.js', 'assets/js/**/*.js'],
                tasks: ['jshint'],
                options: {
                    spawn: false
                }
            },
            sass: {
                files: ['sass/**/*.scss'],
                tasks: ['compass:dev'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');

    grunt.registerTask('default', ['jshint', 'compass:dist']);
};
