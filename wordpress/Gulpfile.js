var projectID = '';

var assetsDir = 'wp-content/themes/yb/assets/';

var gulp = require('gulp'),
    sourcemaps = require('gulp-sourcemaps'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    browserSync = require('browser-sync').create(),
    del = require('del');

var paths = {
    css: {
        src: [assetsDir + 'styles/scss'],
        dist: assetsDir + 'styles/css'
    },
    js: {
        src: [assetsDir + 'scripts/source'],
        dist: assetsDir + 'scripts/build'
    },
    img: {
        src: [assetsDir + 'images'],
        dist: assetsDir + 'images'
    }
};

gulp.task('lint', function() {
    return gulp.src(paths.js.src + '/**/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

gulp.task('styles', function() {
    return sass(paths.css.src + '/**/*.scss', { sourcemap: true })
        .pipe(sourcemaps.init())
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        .pipe(minifycss({compatibility: 'ie8'}))
        .pipe(rename({suffix: '.min'}))
        .pipe(autoprefixer('last 2 version'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.css.dist))
        .pipe(notify({ message: 'Styles task complete' }))
        .pipe(browserSync.stream({match: '**/*.css'}));
});

gulp.task('styles-dist', function() {
    return sass(paths.css.src + '/**/*.scss', { style: 'compressed' })
        .pipe(minifycss())
        .pipe(rename({suffix: '.min'}))
        .pipe(autoprefixer('last 2 version'))
        .pipe(gulp.dest(paths.css.dist))
        .pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('scripts', function() {
    return gulp.src(paths.js.src + '/**/*.js')
        .pipe(concat('main.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(paths.js.dist))
        .pipe(notify({ message: 'Scripts task complete' }))
        .pipe(browserSync.stream());
});

gulp.task('scripts-dist', function() {
    return gulp.src(paths.js.src + '/**/*.js')
        .pipe(concat('main.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(paths.js.dist))
        .pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('images', function() {
    return gulp.src([paths.img.src + '/**/*'])
        .pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
        .pipe(gulp.dest(paths.img.dist))
        .pipe(notify({ message: 'Images task complete' }));
});

gulp.task('clean', function() {
    return del([paths.css.dist, paths.js.dist, paths.img.dist]);
});

gulp.task('watch', function() {
    browserSync.init({
        proxy: projectID + ".yb"
    });

    // Watch .scss files
    gulp.watch(paths.css.src + '/**/*.scss', ['styles']);

    // Watch .js files
    gulp.watch(paths.js.src + '/**/*.js', ['scripts']);
});

gulp.task('default', ['watch']);
gulp.task('deploy', ['clean', 'lint', 'styles-dist', 'scripts-dist', 'images']);
