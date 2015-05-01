modal = null;
ajax = null;

Ajax = function () {
};

Ajax.default = {
    url                    : null,
    data                   : undefined,
    openModalOnError       : true,
    errorModalDialogContent: $('<div/>')
        .append($('<div class="modal-header"/>')
            .append($('<button type="button" class="close" data-dismiss="modal"/>')
                .append($('<span aria-hidden="true"/>').html('&times;'))
                .append($('<span class="sr-only"/>').html('Close')))
            .append($('<h4 class="modal-title" />')
                .append($('<i class="icon-io-notification"/>'))
                .append('&nbsp;Error occurred')))
        .append($('<div class="modal-body"/>')
            .append($('<div class="alert alert-warning" />')
                .html('Error occurred during request. Please contact to page maintainer.')))
        .html()
};

/**
 * @param {String} url
 * @param {object} options
 * @returns {*}
 */
Ajax.prototype.ajax = function (url, options) {
    var jqXHR;

    options = $.extend({}, Ajax.default, options);

    jqXHR = $.ajax(url, options);
    this.registerErrorHandler(jqXHR, options);

    return jqXHR;
};

Ajax.prototype.registerErrorHandler = function (jqXHR, options) {
    jqXHR.fail(function (jqXHR, textStatus, errorThrown) {
        if (options.openModalOnError) {
            modal.open(options.errorModalDialogContent);
        }
        try {
            console.log(errorThrown, $.parseJSON(jqXHR.responseText));
        } catch (e) {
            console.log(errorThrown, {responseText: jqXHR.responseText});
        }
    });
};

Modal = function () {
    this._modal = $('#modal');
    this._content = this._modal.find('.modal-content');
    this._dialog = this._modal.find('.modal-dialog');
};

Modal.default = {
    open    : {
        content: null,
        size   : null
    },
    ajaxOpen: {
        ajax               : {},
        loadingModalContent: $('<div/>')
            .append($('<div class="modal-body"/>')
                .append($('<div class="text-center"/>')
                    .append($('<i class="icon-io-hour-glass"/>'))))
            .html()
    }
};

Modal.prototype.ajax = function (url, options) {
    var self, jqXHR;

    self = this;
    options = $.extend({}, Modal.default.ajaxOpen, options);

    self.open(options.loadingModalContent, {
        size: 'sm'
    });

    jqXHR = ajax.ajax(url, options.ajax);

    jqXHR.done(function (data) {
        self.open(data);
    });
};

Modal.prototype.open = function (content, options) {
    options = $.extend({}, Modal.default.open, options);

    this._dialog.removeClass('modal-sm');
    if (options.size === 'lg') {
        this._dialog.addClass('modal-lg');
    } else if (options.size !== 'sm') {
        this._dialog.removeClass('modal-sm');
    }
    this._content.html(content);
    this._modal.modal({
        backdrop: 'static',
        keyboard: false
    });
};

/** @type {Ajax} */
ajax = new Ajax();
/** @type {Modal} */
modal = new Modal();

(function ($) {
    'use strict';

    var temp;

    if ($.fn.tooltip) {
        temp = {
            container: 'body',
            selector : '[rel=tooltip]'
        };
        $(document).tooltip(temp);
    }

    if ($.fn.popover) {
        temp = {
            html     : true,
            container: 'body',
            selector : '[rel=popover]'
        };
        $(document).popover(temp);
    }

    $('body')
        .on('click', '[class^=js-btn-]', function (e) {
            e.preventDefault();
            e.returnValue = false;
        })
    ;

    $('#modal')
        .on('reload.bs.modal', function (e) {
            $(this).find('select.multiple').multiselect();
        })
        .on('loaded.bs.modal', function (e) {
            $(this).find('select.multiple').multiselect();
        })
        .on('hidden.bs.modal', function (e) {
            $(this).removeData('bs.modal');
            $(this).find('.modal-content').html('');
            $(this).find('.modal-dialog').removeClass('modal-sm');
            $(this).find('.modal-dialog').removeClass('modal-lg');
        })
        .on('keydown', 'input[data-index]', function (e) {
            if (e.which == 13) {
                var index = parseFloat($(e.target).attr('data-index'));

                $('#modal').find('[data-index="' + (index + 1).toString() + '"]')
                    .focus()
                    .click();

                e.preventDefault();
                return false;
            }
        })
    ;

    if ($.fn.multiselect) {
        $('select.multiple').multiselect();
    }

    $(document).ready(function () {
        var pageHeaderTopOffset;

        if ($.fn.scrollspy) {
            pageHeaderTopOffset = $('.page-header').outerHeight(true) + $('.wiki-page-header').outerHeight(true);

            $('body').scrollspy({
                target: '.wiki-navbar-toc',
                offset: pageHeaderTopOffset
            });
        }

        if ($.fn.affix) {
            $('.wiki-page-toc').affix({
                offset: {
                    top   : function () {
                        return (this.top = $('.wiki-page-toc').offset().top);
                    },
                    bottom: function () {
                        return (this.bottom = $('.footer').outerHeight(true));
                    }
                }
            });
        }
    });

}(jQuery));

