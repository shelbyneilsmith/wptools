var projectID = '';
var localTLD = '';
var assetsDir = '';

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
    cssBase64 = require('gulp-css-base64'),
    del = require('del');

var paths = {
    css: {
        src: [assetsDir + 'source/scss'],
        dist: assetsDir + 'css'
    },
    js: {
        src: [assetsDir + 'source/js'],
        dist: assetsDir + 'js'
    },
    img: {
        src: [assetsDir + 'source/img'],
        dist: assetsDir + 'img'
    }
};

gulp.task('lint', function() {
    return gulp.src(paths.js.src + '/**/*.js')
        .pipe(jshint({"globals": ["jQuery", "alert", "Modernizr", "MyAjax", "G_vmlCanvasManager", "WebFontConfig", "Raphael", "SVGStateMap"]}))
        .pipe(jshint.reporter('default'));
});

gulp.task('styles', function() {
    return sass(paths.css.src + '/**/*.scss', { sourcemap: true, require: ['susy'], })
        .pipe(sourcemaps.init())
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        .pipe(minifycss({compatibility: 'ie8'}))
        .pipe(rename({suffix: '.min'}))
        .pipe(autoprefixer('last 2 version'))
        .pipe(cssBase64({
            extensionsAllowed: ['.gif', '.jpg', '.png']
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.css.dist))
        .pipe(notify({ message: 'Styles task complete' }))
        .pipe(browserSync.stream({match: '**/*.css'}));
});

gulp.task('styles-dist', function() {
    return sass(paths.css.src + '/**/*.scss', { style: 'compressed', require: ['susy'] })
        .pipe(minifycss())
        .pipe(rename({suffix: '.min'}))
        .pipe(autoprefixer('last 2 version'))
         .pipe(cssBase64({
            extensionsAllowed: ['.gif', '.jpg', '.png']
        }))
       .pipe(gulp.dest(paths.css.dist))
        .pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('scripts', function() {
    return gulp.src(paths.js.src + '/**/*.js')
        // .pipe(concat('main.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(paths.js.dist))
        .pipe(notify({ message: 'Scripts task complete' }))
        .pipe(browserSync.stream());
});

gulp.task('scripts-dist', function() {
    return gulp.src(paths.js.src + '/**/*.js')
        // .pipe(concat('main.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(paths.js.dist))
        .pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('images', function() {
    return gulp.src([paths.img.src + '/**/*'])
        .pipe(cache(imagemin({ pngquant: true, progressive: true, interlaced: true })))
        .pipe(gulp.dest(paths.img.dist))
        .pipe(notify({ message: 'Images task complete' }));
});

gulp.task('clean', function() {
    return del([paths.css.dist, paths.js.dist]);
});

gulp.task('watch', function() {
    browserSync.init({
        proxy: projectID + "." + localTLD,
});

    // Watch .scss files
    gulp.watch(paths.css.src + '/**/*.scss', ['styles']);

    // Watch .js files
    gulp.watch(paths.js.src + '/**/*.js', ['scripts']);

    // Watch image files
    gulp.watch(paths.img.src + '/**/*', ['images']);
});

gulp.task('default', ['watch']);
gulp.task('deploy', ['clean', 'lint', 'styles-dist', 'scripts-dist', 'images']);
