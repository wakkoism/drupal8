/*eslint strict: ["error", "global"]*/
'use strict';

//=======================================================
// Include gulp
//=======================================================
var gulp = require('gulp');

//=======================================================
// Include Our Plugins
//=======================================================
var sass        = require('gulp-sass');
var prefix      = require('gulp-autoprefixer');
var sourcemaps  = require('gulp-sourcemaps');
var sync        = require('browser-sync');
var babel       = require('gulp-babel');
var rename      = require('gulp-rename');

// Export our tasks.
module.exports = {

  // Compile Sass.
  sass: function() {
    return gulp.src('./src/{global,components}/**/*.scss')
      .pipe(sass({ outputStyle: 'nested' })
        .on('error', sass.logError))
      .pipe(rename(function (path) {
        path.dirname = '';
        return path;
      }))
      .pipe(gulp.dest('./dist/css'))
      .pipe(sync.stream({match: '**/*.css'}));
  },

  // Compile JavaScript.
  js: function() {
    return gulp.src([
      './src/{global,components}/**/*.es6.js'
    ], { base: './' })
      .pipe(sourcemaps.init())
      .pipe(babel())
      .pipe(rename(function (path) {
        path.dirname = '';
        path.basename = path.basename.replace(/\.es6/, '');
        return path;
      }))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('./dist/js'));
  }
};
