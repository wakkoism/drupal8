/*eslint strict: ["error", "global"]*/
'use strict';

//=======================================================
// Include gulp
//=======================================================
var gulp = require('gulp');

//=======================================================
// Include Our Plugins
//=======================================================
var sync = require('browser-sync');
var runSequence = require('run-sequence');

//=======================================================
// Include Our tasks.
//
// Each task is broken apart to it's own node module.
// Check out the ./gulp-tasks directory for more.
//=======================================================
var taskCompile = require('./gulp-tasks/compile.js');
var taskMove = require('./gulp-tasks/move.js');
var taskLint = require('./gulp-tasks/lint.js');

//=======================================================
// Compile Our Sass and JS
// We also move some files if they don't need
// to be compiled.
//=======================================================
gulp.task('compile', ['compile:sass', 'compile:js']);

// Compile Sass
gulp.task('compile:sass', function () {
  return taskCompile.sass();
});

// Compile JavaScript ES2015 to ES5.
gulp.task('compile:js', function () {
  return taskCompile.js();
});

// If some JS components aren't es6 we want to simply move them
// into the dist folder. This allows us to clean the dist/js
// folder on build.
gulp.task('move:js', function () {
  //return taskMove.js();
});

//=======================================================
// Lint Sass and JavaScript
//=======================================================
gulp.task('lint', ['lint:sass', 'lint:js']);


gulp.task('default', ['compile']);

// Lint Sass based on .sass-lint.yml config.
gulp.task('lint:sass', function () {
  return taskLint.sass();
});

// Lint JavaScript based on .eslintrc config.
gulp.task('lint:js', function () {
  return taskLint.js();
});
