var path = require('path');

/**
 * @param {Gulper} gulper
 * @constructor
 */
var AdminGulper = function (gulper) {
    gulper
        .registerCopyTask([
                              path.join(__dirname, 'icomoon', 'fonts', '**')
                          ], path.join('css', 'fonts'))
        .registerCssTask([
                             path.join(__dirname, 'icomoon', 'style.less'),
                             path.join(__dirname, 'style.css')
                         ], path.join('css', 'main.css'))
        .registerJsTask([
                            path.join(__dirname, 'script.js')
                        ], path.join('js', 'main.js'))
};

module.exports = AdminGulper;