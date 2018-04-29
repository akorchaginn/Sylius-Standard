var concat = require('gulp-concat');
var env = process.env.GULP_ENV;
var gulp = require('gulp');
var gulpif = require('gulp-if');
var livereload = require('gulp-livereload');
var merge = require('merge-stream');
var order = require('gulp-order');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var argv = require('yargs').argv;

var rootPath = argv.rootPath;
var shopRootPath = rootPath + 'shop/';
var imageBundlePath = '../ImageBundle/';
var vendorPath = argv.vendorPath || '../../vendor/sylius/sylius/src/Sylius/Bundle/';
var vendorShopPath = '' === vendorPath ? '' : vendorPath + 'ShopBundle/';
var vendorUiPath = '' === vendorPath ? '../UiBundle/' : vendorPath + 'UiBundle/';
var nodeModulesPath = argv.nodeModulesPath;


var paths = {
    shop: {
        js: [
            nodeModulesPath + 'jquery/dist/jquery.min.js',
            nodeModulesPath + 'semantic-ui-css/semantic.min.js',
            nodeModulesPath + 'lightbox2/dist/js/lightbox.js',
            nodeModulesPath + 'slick-carousel/slick/slick.js',
            nodeModulesPath + 'slicknav/dist/jquery.slicknav.js',
            vendorUiPath + 'Resources/private/js/**',
            vendorShopPath + 'Resources/private/js/**',
            'Resources/private/shop/js/**'
        ],
        sass: [
            //vendorUiPath + 'Resources/private/sass/**',
            //vendorShopPath + 'Resources/private/sass/**',
            'Resources/private/shop/sass/**'
        ],
        css: [
            nodeModulesPath + 'semantic-ui-css/semantic.min.css',
            nodeModulesPath + 'lightbox2/dist/css/lightbox.css',
            nodeModulesPath + 'slicknav/dist/slicknav.css',
            vendorUiPath + 'Resources/private/css/**',
            vendorShopPath + 'Resources/private/css/**',
            vendorShopPath + 'Resources/private/scss/**',
            imageBundlePath + 'Resources/private/css/**'
        ],
        img: [
            vendorShopPath + 'Resources/private/img/**',
            'Resources/private/shop/img/**',
            imageBundlePath + 'Resources/private/img/**'
        ]
    }
};

gulp.task('shop-js', function () {
    return gulp.src(paths.shop.js)
        .pipe(concat('app.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(shopRootPath + 'js/'))
    ;
});

gulp.task('shop-css', function() {
    gulp.src([nodeModulesPath + 'semantic-ui-css/themes/**/*']).pipe(gulp.dest(shopRootPath + 'css/themes/'));

    var cssStream = gulp.src(paths.shop.css)
            .pipe(concat('css-files.css'))
        ;
        
    var sassStream = gulp.src(paths.shop.sass)
            .pipe(sass())
            .pipe(concat('sass-files.scss'))
        ;

    return merge(cssStream, sassStream)
        .pipe(order(['css-files.css', 'sass-files.scss']))
        .pipe(concat('style.css'))
        .pipe(gulpif(env === 'prod', uglifycss()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(shopRootPath + 'css/'))
        .pipe(livereload())
    ;
});

gulp.task('shop-img', function() {
    gulp.src([nodeModulesPath + 'lightbox2/dist/images/*']).pipe(gulp.dest(shopRootPath + 'images/'));    
    
    return gulp.src(paths.shop.img)
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(shopRootPath + 'img/'))
    ;
});

gulp.task('shop-watch', function() {
    livereload.listen();

    gulp.watch(paths.shop.js, ['shop-js']);
    gulp.watch(paths.shop.sass, ['shop-css']);
    gulp.watch(paths.shop.css, ['shop-css']);
    gulp.watch(paths.shop.img, ['shop-img']);
});


/**
 * TODO: Оптимизировать использование bootstrap, fonts, images!
 */
gulp.task('bootstrap', function(){ 
    return gulp.src('Resources/private/shop/css/**')
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(shopRootPath + 'css/'))
    ;
});


gulp.task('fonts', function(){ 
    return gulp.src('Resources/private/shop/fonts/**')
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(shopRootPath + 'fonts/'))
    ;
});

gulp.task('images', function(){ 
    return gulp.src('Resources/private/shop/images/**')
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(shopRootPath + 'images/'))
    ;
});
/**
 * TODO: Оптимизировать использование bootstrap, fonts, images!
 */

gulp.task('catalog-promotion', function() {
    return gulp.src([
        '../../node_modules/jquery/dist/jquery.min.js',
        '../../vendor/sylius/sylius/src/Sylius/Bundle/UiBundle/Resources/private/js/sylius-prototype-handler.js',
        '../../vendor/sylius/sylius/src/Sylius/Bundle/UiBundle/Resources/private/js/sylius-form-collection.js',
        '../../vendor/urbanara/catalog-promotion-plugin/src/Resources/public/**'
    ])
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('../../web/assets/catalog/' + 'js/'))
        ;
});

gulp.task('default', ['shop-js', 'shop-css', 'shop-img', 'catalog-promotion', 'bootstrap', 'fonts','images']);
gulp.task('watch', ['default', 'shop-watch']);
