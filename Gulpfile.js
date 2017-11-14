var gulp = require('gulp');
var chug = require('gulp-chug');
var argv = require('yargs').argv;

config = [
    '--rootPath',
    argv.rootPath || '../../web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../node_modules/'
];

/**
 gulp.task('admin', function() {
    gulp.src('vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
 });

gulp.task('shop', function() {
    gulp.src('vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});
*/
gulp.task('app_shop', function() {
    gulp.src('src/AppBundle/GulpFile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('app_admin', function() {
    
    gulp.src('src/AppBundle/GulpFile-admin.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});


gulp.task('default', ['app_shop', 'app_admin']);
