'use strict';

var gulp = require('gulp');
var newer = require('gulp-newer');
var sass = require('gulp-sass');
var cssnano = require('gulp-cssnano');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var del = require("del");

// Configuration file to keep your code DRY
var cfg = require("./gulpconfig.json");
var paths = cfg.paths;

// Styles/CSS
gulp.task('styles', function(done) {
	gulp
		.src([
			'./src/sass/**/*.scss',
			'!src/sass/import/', //exclude import'
			'!src/sass/import/**/*'
		])
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
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
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./assets/css/'));

	done();
});

// Scripts/JS
gulp.task('scripts', function(done) {
	gulp
		.src([
			'./src/js/**/*.js',
			'!src/js/import/', //exclude import'
			'!src/js/import/**/*'
		])
		.pipe(uglify())
		.pipe(gulp.dest('./assets/js/'));

	done();
});

// Images
var imgDest = './assets/images/';
gulp.task('images', function(done) {
	gulp
		.src('./src/images/**/*')
		.pipe(newer(imgDest))
		.pipe(imagemin())
		.pipe(gulp.dest(imgDest));

	done();
});

function build() {
	gulp.series('styles', 'scripts', 'images')();
}
gulp.task('build', function(done) {
	build();
	done();
});

gulp.task('watch', function() {
	gulp.watch('./src/sass/**/*.scss', gulp.series('styles'));
	gulp.watch('./src/js/**/*.js', gulp.series('scripts'));
	gulp.watch('./src/images/**/*', gulp.series('images'));
});

// Deleting any file inside the /src folder
gulp.task("clean-assets", function() {
	return del(["assets/**/*"]);
});

// Run:
// Deleting any file inside the /dist folder
gulp.task("clean-dist", function() {
	return del([`${paths.dist}/**`]);
});

// Run:
// gulp dist
// Copies the files to the /dist folder for distribution as simple theme
gulp.task(
	"create-dist",
	gulp.series("clean-dist", function copyToDistFolder() {
		const ignorePaths = [
				`!${paths.node}`,
				`!${paths.src}`,
				`!${paths.media}`,
				`!${paths.dist}`,
				`!${paths.dist}/**`
			],
			ignoreFiles = [
				"!package.json",
				"!package-lock.json",
				"!gulpfile.js",
				"!gulpconfig.json",
				"!jshintignore",
				"!.gitignore"
			];

		console.log({ ignorePaths, ignoreFiles });

		return gulp
			.src(["**/*", "assets/**/**.*", "*", ...ignorePaths, ...ignoreFiles], {
				buffer: false
			})
			.pipe(gulp.dest(paths.dist));
	})
);

// Dist project
gulp.task(
	"dist",
	gulp.series(
		"clean-assets",
		"images",
		gulp.series("styles", "scripts", "create-dist")
	)
);
