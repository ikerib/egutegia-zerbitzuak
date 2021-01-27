/**
 * egutegia31
 * Created by iibarguren on 3/13/17.
 */

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    cssnext = require('postcss-cssnext'),
    cssnano = require('gulp-cssnano'),
    livereload = require('gulp-livereload'),
    modernizr = require('gulp-modernizr'),
    merge = require('merge-stream'),
    plumber = require('gulp-plumber'),
    postcss = require('gulp-postcss'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    scsslint = require('gulp-scss-lint'),
    del = require('del'),
    uglify = require('gulp-uglify'),
    notify = require("gulp-notify"),
    minify = require('gulp-minify'),
    bower = require('gulp-bower'),
    babel = require('gulp-babel');

var config = {
    sassPath: './app/Resources/assets/scss',
    bowerDir: './app/Resources/assets/js'
};

var paths = {
    npm: './node_modules',
    sass: ['./app/Resources/assets/scss/app.scss', './app/Resources/assets/js/font-awesome/scss/font-awesome.scss'],
    js: './app/Resources/assets/js',
    svg: './app/Resources/assets/svg',
    buildCss: './web/css',
    buildJs: './web/js',
    buildSvg: './web/svg'
};

otherFonts = [
    config.bowerDir + '/font-awesome/fonts/**.*',
    config.bowerDir + '/bootstrap/fonts/**.*'
];

freeIMG = [
    './app/Resources/assets/js/bootstrap-colorpicker/dist/img/**/*',
    './app/Resources/assets/img/**/*'
];
freeJS = [
    './app/Resources/assets/js/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    './app/Resources/assets/js/vertical-timeline/vertical-timeline.js',
    './app/Resources/assets/js/calendar-template.js',
    './app/Resources/assets/js/calendar-admin.js',
    './app/Resources/assets/js/calendar-edit-admin.js',
    './app/Resources/assets/js/calendar-user.js',
    './app/Resources/assets/js/calendar-compare.js',
    './app/Resources/assets/js/libs/select2.min.js',
    './app/Resources/assets/js/libs/select2-locale/es.js',
    './app/Resources/assets/js/libs/select2-locale/eu.js',
    './app/Resources/assets/js/calendar-share.js'
];

freeCSS = [
    './app/Resources/assets/js/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css'
];

otherJS = [
    './app/Resources/assets/js/libs/respond.min.js',
    './app/Resources/assets/js/jquery/dist/jquery.min.js',
    './app/Resources/assets/js/libs/jquery-ui.js',
    './app/Resources/assets/js/bootstrap/dist/js/bootstrap.min.js',
    './app/Resources/assets/js/bootstrap-year-calendar/js/bootstrap-year-calendar.min.js',
    './app/Resources/assets/js/bootstrap-year-calendar/js/languages/bootstrap-year-calendar.eu.js',
    './app/Resources/assets/js/bootstrap-year-calendar/js/languages/bootstrap-year-calendar.es.js',
    './app/Resources/assets/js/bootstrap-table/dist/bootstrap-table.min.js',
    './app/Resources/assets/js/bootstrap-table/dist/locale/bootstrap-table-eu-EU.js',
    './app/Resources/assets/js/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js',
    './app/Resources/assets/js/bootstrap-table/dist/extensions/export/tableExport.js',
    './app/Resources/assets/js/bootstrap-table/dist/extensions/export/jspdf.js',
    './app/Resources/assets/js/bootstrap-table/dist/extensions/export/jspdf.plugin.autotable.js',
    './app/Resources/assets/js/libs/bootstrap-datepicker.min.js',
    './app/Resources/assets/js/libs/bootstrap-popover.js',
    './app/Resources/assets/js/bootbox/bootbox.min.js',
    './app/Resources/assets/js/moment/min/moment-with-locales.min.js',
    './app/Resources/assets/js/libs/bootstrap-datepicker.es.min.js',
    './app/Resources/assets/js/libs/bootstrap-datepicker.eu.min.js',
    './app/Resources/assets/js/app.js'
];
otherCSS = [
    './app/Resources/assets/js/bootstrap/dist/css/bootstrap.css',
    './app/Resources/assets/js/bootstrap/dist/css/bootstrap-theme.css',
    './app/Resources/assets/js/bootstrap-year-calendar/css/bootstrap-year-calendar.min.css',
    './app/Resources/assets/js/bootstrap-table/dist/bootstrap-table.css',
    './app/Resources/assets/js/vertical-timeline/vertical-timeline.css',
    './app/Resources/assets/js/libs/bootstrap-datepicker.min.css',
    './app/Resources/assets/js/libs/select2.min.css',
    './app/Resources/assets/'
];

function onError(err) {
    console.log(err);
    this.emit('end');
}

// UTILS
gulp.task('watch', function () {
    gulp.watch('./app/Resources/assets/scss/**/*.scss', ['sass:dev']);
    gulp.watch('./app/Resources/assets/js/*.js', ['js:dev'])
});

gulp.task('bower', function () {
    return bower()
        .pipe(gulp.dest(config.bowerDir))
});

gulp.task('clean', function () {
    return del([
        'web/css/*',
        'web/js/*',
        'web/fonts/*'
    ]);
});

gulp.task('icons', function () {
    return gulp.src(otherFonts)
        .pipe(gulp.dest('./web/fonts'));

});

gulp.task('scss-lint', function () {
    gulp.src([
        paths.sass + '/**/*.scss',
        '!' + paths.sass + '/base/_reset.scss'
    ])
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(scsslint());
});

// CSS
gulp.task('css:dev', function () {
    return gulp.src(otherCSS)
        .pipe(gulp.dest('web/css/'));
});

gulp.task('sass:dev', ['css:dev', 'scss-lint'], function () {
    gulp.src(freeCSS)
        .pipe(gulp.dest('web/css/'));

    gulp.src(freeIMG)
        .pipe(gulp.dest('web/img/'));
    gulp.src(paths.sass)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(sass({
            errLogToConsole: true
        }))
        .pipe(postcss([cssnext]))
        .pipe(gulp.dest(paths.buildCss))
        .pipe(livereload());
});

gulp.task('sass:prod', function () {
    gulp.src(freeCSS)
        .pipe(gulp.dest('web/css/'));

    gulp.src(freeIMG)
        .pipe(gulp.dest('web/img/'));


    return merge (
        gulp.src(otherCSS)
            .pipe(cssnano({keepSpecialComments: 1,rebase: false}))
            .pipe(gulp.dest(paths.buildCss)),
        gulp.src(paths.sass)
            .pipe(plumber({errorHandler: onError}))
            .pipe(sass({errLogToConsole: true}))
            .pipe(postcss([cssnext]))
            .pipe(cssnano({keepSpecialComments: 1,rebase: false}))
            .pipe(gulp.dest(paths.buildCss))


    ).pipe(concat('app.min.css')).pipe(gulp.dest(paths.buildCss));;


    // return merge(niresass, besteCss).pipe(concat('app.min.css')).pipe(gulp.dest(paths.buildCss));
});

// JS
gulp.task('js:dev', function () {
    gulp.src(freeJS)
      .pipe(babel({presets: ['es2015']}))
      .pipe(gulp.dest('web/js/'));
    return gulp.src(otherJS)
        .pipe(gulp.dest('web/js/'));
});

gulp.task('js:prod', function () {
    gulp.src(freeJS)
      .pipe(babel({presets: ['es2015']}))
      .pipe(minify())
      .pipe(gulp.dest('web/js/'));
    return gulp.src(otherJS)
        .pipe(minify())
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('web/js/'));
});


// Task guztiak batuz
gulp.task('prod', ['icons', 'js:prod', 'sass:prod']);

gulp.task('dev', ['icons', 'js:dev', 'sass:dev']);

gulp.task('default', ['clean', 'icons', 'js:dev', 'sass:dev', 'watch']);

// gulp.task('prod', ['sass:prod', 'modernizr', 'js:prod']);