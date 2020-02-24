"use strict";

var gulp = require("gulp");
var newer = require("gulp-newer");
var sass = require("gulp-sass");
var cssnano = require("gulp-cssnano");
var sourcemaps = require("gulp-sourcemaps");
var autoprefixer = require("gulp-autoprefixer");
var uglify = require("gulp-uglify");
var imagemin = require("gulp-imagemin");

// Styles/CSS
gulp.task("styles", function(done) {
  gulp
    .src([
      "./src/sass/**/*.scss",
      "!src/sass/import/", //exclude import'
      "!src/sass/import/**/*"
    ])
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(
      autoprefixer({
        cascade: false
      })
    )
    .pipe(
      cssnano({
        discardComments: { removeAll: true },
        convertValues: { length: false }
      })
    )
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest("./assets/css/"));

  done();
});

// Scripts/JS
gulp.task("scripts", function(done) {
  gulp
    .src([
      "./src/js/**/*.js",
      "!src/js/import/", //exclude import'
      "!src/js/import/**/*"
    ])
    .pipe(uglify())
    .pipe(gulp.dest("./assets/js/"));

  done();
});

// Images
var imgDest = "./assets/images/";
gulp.task("images", function(done) {
  gulp
    .src("./src/img/**/*")
    .pipe(newer(imgDest))
    .pipe(imagemin())
    .pipe(gulp.dest(imgDest));

  done();
});

function build() {
  return gulp.parallel("styles", "scripts" /*, "images"*/)();
}

gulp.task("watch", function() {
  gulp.watch(
    ["./src/sass/**/*.scss", "./src/js/**/*.js", "./src/img/**/*"],
    build()
  );
});
gulp.task("build", function(done) {
  build();
  done();
});
