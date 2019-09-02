'use strict';

var gulp = require('gulp');
   
var sass = require("gulp-sass");


gulp.task('sass', async function() {
    return gulp.src('src/scss/style.scss')
    .pipe(sass()) // Using gulp-sass
    .pipe(gulp.dest('src/css/style.css'))
  });

  