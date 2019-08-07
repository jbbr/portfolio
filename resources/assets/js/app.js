require('./bootstrap');

require('../lib/semantic/dist/semantic.min.js');

require('./translate');


Number.prototype.padLeft = function (n, str) {
    return (this < 0 ? '-' : '') +
        Array(n - String(Math.abs(this)).length + 1)
            .join(str || '0') +
        (Math.abs(this));
};

$(function () {
    $('.ui.dropdown').not('.no-addition').dropdown({allowAdditions: true});
    $('.ui.dropdown.no-addition').dropdown({allowAdditions: false});

    $('.message .close').on('click', function () {
        $(this).closest('.message').transition('fade');
    });

    $('.ui.label').popup({
        hoverable: true,
        position: 'top left',
    });

    $("[data-calendar-type]").each(function () {
        var type = $(this).attr('data-calendar-type');
        var calFrom = null;
        var calTo = null;

        var calGroup = $(this).parents('.calendar-group');
        if (calGroup.length > 0) {
            if ($(this).hasClass('date-from')) {
                calTo = calGroup.find('.date-to');
            }
            if ($(this).hasClass('date-to')) {
                calFrom = calGroup.find('.date-from');
            }
        }

        $(this).calendar({
            type: type,
            firstDayOfWeek: 1,
            ampm: false,
            startCalendar: calFrom,
            endCalendar: calTo,
            text: {
                days: ['S', 'M', 'D', 'M', 'D', 'F', 'S'],
                months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
                today: 'Heute',
                now: 'Jetzt',
            },
            formatter: {
                date: function (date) {
                    return date.getDate().padLeft(2) + '.' + (date.getMonth() + 1).padLeft(2) + '.' + date.getFullYear();
                },
            },
            parser: {
                date: function (text) {
                    var parts = text.split('.');
                    return new Date(parseInt(parts[2], 10),
                        parseInt(parts[1], 10) - 1,
                        parseInt(parts[0], 10));
                }
            },
            onChange: function () {
                setTimeout(dateutils.updateDuration, 10);
            },
            onHidden: function() {
                filter();
            }
        });
    });
    dateutils.updateDuration();

    $('.menu .item').tab();

    if (typeof DropzoneTranslations !== "undefined") {
        if ($('#media-fileupload').length > 0) {
            window.mediaFileupload = new Dropzone("#media-fileupload", {
                url: $(this).attr('url'),
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.docx,.doc,.mp4,.mp3,.ogg",
                addRemoveLinks: true,
                maxFilesize: 500,

                dictDefaultMessage: DropzoneTranslations.dictDefaultMessage,
                dictFallbackMessage: DropzoneTranslations.dictFallbackMessage,
                dictFallbackText: DropzoneTranslations.dictFallbackText,
                dictFileTooBig: DropzoneTranslations.dictFileTooBig,
                dictInvalidFileType: DropzoneTranslations.dictInvalidFileType,
                dictResponseError: DropzoneTranslations.dictResponseError,
                dictCancelUpload: DropzoneTranslations.dictCancelUpload,
                dictCancelUploadConfirmation: DropzoneTranslations.dictCancelUploadConfirmation,
                dictRemoveFile: DropzoneTranslations.dictRemoveFile,
                dictRemoveFileConfirmation: DropzoneTranslations.dictRemoveFileConfirmation,
                dictMaxFilesExceeded: DropzoneTranslations.dictMaxFilesExceeded,

                sending: function (file, xhr, formData) {
                    formData.append("_token", $('[name=csrf-token]').attr('content'));
                    dimmer.start();
                },
                success: function (file, response) {
                    $('#media-list').html(response.view);
                    this.removeFile(file);
                    dimmer.stop();
                    $('.ui.accordion').accordion();
                }
            });
        }
        if ($('#entries-media-upload').length > 0) {
            window.entriesFileupload = new Dropzone('#entries-media-upload', {
                url: $('#entries-media-upload').data('url'),
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 10,
                parallelUploads: 10,
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.docx,.doc,.mp4,.mp3,.ogg",
                addRemoveLinks: true,
                maxFilesize: 500,

                dictDefaultMessage: DropzoneTranslations.dictDefaultMessage,
                dictFallbackMessage: DropzoneTranslations.dictFallbackMessage,
                dictFallbackText: DropzoneTranslations.dictFallbackText,
                dictFileTooBig: DropzoneTranslations.dictFileTooBig,
                dictInvalidFileType: DropzoneTranslations.dictInvalidFileType,
                dictResponseError: DropzoneTranslations.dictResponseError,
                dictCancelUpload: DropzoneTranslations.dictCancelUpload,
                dictCancelUploadConfirmation: DropzoneTranslations.dictCancelUploadConfirmation,
                dictRemoveFile: DropzoneTranslations.dictRemoveFile,
                dictRemoveFileConfirmation: DropzoneTranslations.dictRemoveFileConfirmation,
                dictMaxFilesExceeded: DropzoneTranslations.dictMaxFilesExceeded,

                init: function () {
                    dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

                    // for Dropzone to process the queue (instead of default form behavior):
                    document.getElementById("button_save").addEventListener("click", function (e) {
                        // Make sure that the form isn't actually being sent.
                        e.preventDefault();
                        e.stopPropagation();

                        if (dzClosure.getQueuedFiles().length === 0) {
                            $('form.ui.form').submit();
                        }

                        dzClosure.processQueue();
                    });

                    this.on("sending", function (data, xhr, formData) {
                        formData.append("_token", $('[name=csrf-token]').attr('content'));
                    });

                    //send all the form data along with the files:
                    this.on("sendingmultiple", function (data, xhr, formData) {
                        formData.append("_token", $('[name=csrf-token]').attr('content'));
                    });

                    this.on('success', function (file, response) {
                        var ele = jQuery('#processed-media-files'),
                            _val = ele.val();

                        if (_val.length === 0) {
                            _val = response.ids;
                        } else {
                            _val += "," + response.ids;
                        }

                        ele.val(_val);
                    });

                    this.on('queuecomplete', function () {
                        $('form.ui.form').submit();
                    })
                }
            });
        }

    }

    $('#media-fileupload-button').on('click', function (e) {
        e.preventDefault();
        mediaFileupload.processQueue();
    });

    $('#media-list').on('click', '.media-edit-btn', function () {
        $.ajax({
            method: 'GET',
            url: '/media/' + $(this).data('mediumid') + '/edit',
            success: function (data) {
                modal.open(data.modal, media.save);
            }
        });
    });

    $('.checklist .master.checkbox').checkbox({
        // check all children
        onChecked: function () {
            var $childCheckbox = $(this).closest('.checklist').find('.child.checkbox');
            $childCheckbox.checkbox('check');

            if ($(this).parent().hasClass('stop-propagate')) {
                window.event.stopPropagation();
            }
        },
        // uncheck all children
        onUnchecked: function () {
            var $childCheckbox = $(this).closest('.checklist').find('.child.checkbox');
            $childCheckbox.checkbox('uncheck');

            if ($(this).parent().hasClass('stop-propagate')) {
                window.event.stopPropagation();
            }
        }
    });

    $('.checklist .child.checkbox').checkbox({
        // Fire on load to set parent value
        fireOnInit: true,
        // Change parent state on each child checkbox change
        onChange: function () {
            var
                $listGroup = $(this).closest('.checklist'),
                $parentCheckbox = $listGroup.find('.master.checkbox'),
                $checkbox = $listGroup.find('.child.checkbox'),
                allChecked = true,
                allUnchecked = true
            ;
            // check to see if all other siblings are checked or unchecked
            $checkbox.each(function () {
                if ($(this).checkbox('is checked')) {
                    allUnchecked = false;
                }
                else {
                    allChecked = false;
                }
            });
            // set parent checkbox state, but dont trigger its onChange callback
            if (allChecked) {
                $parentCheckbox.checkbox('set checked');
            }
            else if (allUnchecked) {
                $parentCheckbox.checkbox('set unchecked');
            }
            else {
                $parentCheckbox.checkbox('set indeterminate');
            }
        }
    });

    $('.slider').on('init', function () {
        $(this).css('visibility', 'visible')
    }).slick();

    if ($('.ui.accordion').length > 0) {
        $('.ui.accordion').accordion();
    }

    // if ($('.trumbowyg').length > 0) {
    //     $('.trumbowyg').trumbowyg({
    //         btns: [
    //             ['formatting'],
    //             ['strong', 'em'],
    //             ['superscript'/*, 'subscript'*/],
    //             ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
    //             ['unorderedList', 'orderedList'],
    //             ['removeformat'],
    //             ['fullscreen']
    //         ],
    //         removeformatPasted: true,
    //         lang: 'de',
    //         svgPath: '/node_modules/trumbowyg/dist/ui/icons.svg',
    //     }).on('tbwchange tbwinit tbwpaste', function () {
    //         var wordCount = $(this).trumbowyg('html').replace(/&nbsp;/gi, " ").replace(/<(?:.|\n)*?>/gm, ' ').trim().split(/\s+/).length;
    //         $('.description-word-counter').html(wordCount);
    //         if ($('#wordcount').length > 0) {
    //             $('#wordcount').val(parseInt(wordCount));
    //         }
    //     });
    // }

    if ($('.tinymce').length > 0) {
        tinymce.init({
            selector: 'textarea.tinymce',
            skin_url: '/tinymce/skins/lightgray/',
            theme_url: '/tinymce/themes/modern/theme.js',
            branding: false,
            elementpath: false,
            inline: false,
            plugins: 'lists advlist autolink link image table wordcount',
            toolbar1: 'undo redo | bold italic | link image | alignleft aligncenter alignright | table code | filebrowser',
            toolbar2: 'formatselect | numlist bullist | outdent indent | superscript subscript',
            menu: {
                file: {title: 'File', items: 'newdocument'},
                edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
                insert: {title: 'Insert', items: 'link media | template hr'},
                view: {title: 'View', items: 'visualaid'},
                format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
                tools: {title: 'Tools', items: 'spellchecker code'}
            },
            menubar: 'file edit table',
            init_instance_callback: function (editor) {

                var wordCount = function (editor) {
                    var countEle = $('#wordcount');
                    if (countEle.length > 0) {
                        countEle.val(editor.plugins.wordcount.getCount());
                    }
                };

                // Set initial value
                wordCount(editor);
                // Change value on every Change
                editor.on('Change', function (e) {
                    wordCount(editor);
                });
            },
            setup: function (editor) {
                editor.addButton('filebrowser', {
                    icon: 'media',
                    tooltip: "Mediathek öffnen",
                    onclick: function () {
                        editor.windowManager.open({
                            title: 'Mediathek',
                            url: '/media/dialog',
                            width: 770,
                            height: 600
                        });
                    }
                });
            }
        });
    }

    $('.help-button').click(function (e) {
        e.preventDefault();
        $('.sidebar')
            .sidebar('setting', 'transition', 'overlay')
            .sidebar('toggle');

        if ($('.sidebar .loading').length > 0) {
            return;
        }

        var url = $(this).attr('href');
        
        
        //TODO: URL kürzen auf die letzten beiden Dashe
        var pathComponents = url.split('/');

        var abschnitt = pathComponents[pathComponents.length-2];
        var htmlFile = pathComponents[pathComponents.length-1];
        
        $('.sidebar').load('/help?url=/' + abschnitt + '/' + htmlFile);
        
        //$('.sidebar').load('/help?url=/dashboard/hilfe_dashboard.html');
    });

    /* Export Buttons */

    $('.ep.export .content').on('click', 'button[name^="preview_"]', function (e) {

        e.preventDefault();

        var form = $('.ep.export .content form'),
            action = $('<input>').attr('name', 'action').css('display', 'none').val($(this).attr('name'));
        var isIE = !!navigator.userAgent.match(/Trident/g) || !!navigator.userAgent.match(/MSIE/g);

        form.append(action);

        switch ($(this).attr('name')) {
            case 'preview_individual':
            case 'individual':
            case 'preview_explicit':
            case 'explicit': {
                // set target to blank for creation and preview
                if (!isIE) {
                    form.attr('target', '_blank');
                }
            }
                break;
            default: {
                // remove target for filter (if previously set)
                form.removeAttr('target');

                // change route to index (if set)
                if ($(this).data('route') !== "") {
                    form.attr('action', $(this).data('route'));
                }
            }
                break;
        }
        // submit the form
        form.submit();

        // remove the action input after submit
        action.remove();

        return false;
    });

    var filterXhr;

    $('.ep.export .filter input').on('change', function(){
        filter();
    });

    function filter() {

        if(!$(document.body).hasClass('ep') || !$(document.body).hasClass('export')) {
            return;
        }

        // dimmer.start();
        if(filterXhr) {
            filterXhr.abort();
        }

        filterXhr = $.ajax({
            method: 'POST',
            url: '/export/filter',
            data: $('form').serializeArray(),
            success: function (response) {
                $('.checklist .item:not(.chbx-master)').remove();
                $('.checklist').append(response.view);
                media.buildMediaSelection();
                // dimmer.stop();
            }
        });
    }

    $('.ep.export .checklist').on('change', 'input[name="entries[]"]', function (event) {
        var _element = $(this).closest('.item').find('.media-selection > .browse');
        if ($(_element).length > 0) {
            if ($(this).prop('checked')) {
                // Enable
                $(_element).removeClass('disabled');
            } else {
                // Disable
                $(_element).addClass('disabled');
            }
        }
    });

    $('[data-filter]').dropdown({
        onChange: function (value, text, $selectedItem) {
            var href = window.location.href.replace(/(page=[^&]*&?)/, '');

            if (href.indexOf('location=') > -1) {
                href = href.replace(/(location=)[^&]+(&?)/, '$1' + $selectedItem.data('location') + '$2');
            } else if (href.indexOf('?') > -1) {
                href = href + "&location=" + $selectedItem.data('location');
            } else {
                href = href + "?location=" + $selectedItem.data('location');
            }

            window.location.href = href;
        }
    });

    /* Export - Media-Selection */
    media.buildMediaSelection();

    $('[data-content]').popup({position: 'top center'});

    if ($('.location-form').length > 0) {
        locations.updateFields();
    }

    if ($('#portfolio_id').length > 0) {
        var $select = $('#portfolio_id');
        var $save = $('#button_save');
        var $copy = $('#button_copy');
        $select.change(function () {
            if ($select.find('option:selected').hasClass('original')) {
                $save.show();
                $copy.hide();
            } else {
                $save.hide();
                $copy.show();
            }
        })
    }

    if ($('.fit-font').length > 0) {
        $('.fit-font').each(function (index, ele) {
            if ($(ele).parent().width() < $(ele).width()) {
                $(ele).css({
                    'font-size': parseFloat($(ele).css('font-size')) * (($(ele).parent().width() / ($(ele).width() / 100)) / 100)
                });
            }
        });
    }

    if ($('.ep.portfolios .ep.ui.card > .content').length > 0) {
        var maxHeight = Math.max.apply(null, $('.ep.portfolios .ep.ui.card > .content').map(function () {
            return $(this).height();
        }).get());

        $('.ep.portfolios .ep.ui.card > .content').height(maxHeight);
    }

    /** color selector - Iro */
    if ($('.color_select_element').length > 0) {

        // each input element
        $('.color_select_element').each(function () {
            // sibling div for iro initialization
            var _input = $('.' + $(this).attr('id'));

            // get the default color if available
            var defaultColor = _input.val();

            // id of the iro element
            var id = '#' + $(this).attr('id');

            // initialize the iro colorpicker
            var ciColorpicker = new iro.default.ColorPicker(id, {
                color: defaultColor,
                width: 320,
                height: 320,
            });

            ciColorpicker.on('color:change', function (color, changes) {
                var input = $('.' + $(ciColorpicker.el).attr('id'));
                if (input.val() !== color.hexString) {
                    input.val(color.hexString);
                }
            });
        });
    }
});

window.portfolio = {
    help: function (portfolioid) {
        $.ajax({
            method: 'GET',
            url: '/portfolios/' + portfolioid + '/help',
            success: function (data) {
                modal.open(data.modal);
            }
        });
    },
};

window.media = {
    preview: function (mediumid) {
        $('#item-' + mediumid + ' .image').prepend('<div class="ui active inverted dimmer"><div class="ui loader"></div></div>');
        $.ajax({
            method: 'GET',
            url: '/media/' + mediumid,
            success: function (data) {
                modal.open(data.modal);

                if ($('.image > .dimmer').length > 0) {
                    $('.image > .dimmer').remove();
                }
            }
        });
    },

    save: function (form) {

        var data = {};
        $.each(form, function (i, obj) {
            data[obj.name] = obj.value
        });

        $.ajax({
            method: 'POST',
            url: '/media/' + data.mediumid,
            data: data,

            success: function (response) {
                $('#item-' + data.mediumid).replaceWith(response.view);

                $('.ui.modal').modal('hide');
            }
        });

    },

    buildMediaSelection: function() {
        if ($('.media-selection').length > 0) {
            $('.media-selection .browse').each(function () {
                $(this).popup({
                    popup: '.entry-media-' + $(this).data('entry'),
                    setFluidWidth: true,
                    exclusive: true,
                    position: 'bottom left',
                    on: 'click',
                    hoverable: true,
                    closable: true,
                    onShow: function() {
                        return !$(this).hasClass('disabled');
                    }
                });
            });

            $('.media-selection').siblings('.popup').each(function () {
                var entryId = $(this).data('entry-id');
                $('input:checkbox[name^=integrate\\[' + entryId + '\\]]').change(function () {
                    if ($('input:checkbox[name^=integrate\\[' + entryId + '\\]]:checked').length > 2) {
                        this.checked = false;
                    }
                });
            });

        }
    }
};

window.share = {
    preview: function () {
        code = $('#code').val()
        $('#import-code').val(code);
        $.ajax({
            method: 'GET',
            url: '/portfolios/code/' + code,
            success: function (data) {
                modal.open(data.modal);
            }
        });
    }
};

window.modal = {
    open: function (data, saveFunction) {
        if (data !== "") {
            $('.ui.modal > .header').html(data.header);
            $('.ui.modal > .content').html(data.content);
            $('.ui.modal > .actions').html(data.actions);

            if ($('.modal-abort-btn').length > 0) {
                $('.modal-abort-btn').on('click', function () {
                    $('.ui.modal').modal('hide');
                });
            }

            if ($('.modal-save-btn').length > 0) {
                $('.modal-save-btn').on('click', function () {
                    $(this).addClass('loading');
                    $('.ui.modal').find('form').each(function (index, element) {
                        if (typeof saveFunction === "function") {
                            saveFunction($(element).serializeArray());
                        }
                    });
                });
            }

            if ($('.modal-submit-btn').length > 0) {
                $('.modal-submit-btn').on('click', function () {
                    $(this).addClass('loading');
                    $('.ui.modal form').submit();
                });
            }

            $('.ui.dropdown').dropdown({allowAdditions: true});
        }

        $('.ui.modal').modal({
            observeChanges: true
        });

        $('.ui.modal').imagesLoaded(function () {
            $('.item .dimmer').remove();
            $('.ui.modal').modal('show');
        });
    }
};

window.locations = {
    updateFields: function () {
        var type = $('#type').val();
        $('.row[data-type]').hide();
        $('.row[data-type="' + type + '"]').show();
    }
}

window.dateutils = {
    updateDuration: function (date) {
        var $dateFrom = $('.date-from');
        var $dateTo = $('.date-to');
        var $duration = $('.duration');

        if (!$dateFrom.length || !$dateTo.length || !$duration.length) {
            return;
        }

        var fromDate = $dateFrom.calendar('get date');
        var toDate = $dateTo.calendar('get date');
        if (fromDate === null || toDate === null) {
            return;
        }

        var days = dateutils.getBusinessDatesCount(fromDate, toDate);
        if (days > 1) {
            $duration.addClass("disabled");
            $duration.dropdown("set selected", (days * 8) + ':00');
            $duration.dropdown("refresh");
        } else {
            $duration.removeClass("disabled");
        }
    },
    getBusinessDatesCount: function (startDate, endDate) {
        var startDate = new Date(startDate.getTime());
        var endDate = new Date(endDate.getTime());
        var count = 0;
        var curDate = startDate;
        while (curDate <= endDate) {
            var dayOfWeek = curDate.getDay();
            if (!((dayOfWeek == 6) || (dayOfWeek == 0)))
                count++;
            curDate.setDate(curDate.getDate() + 1);
        }
        return count;
    }
}

window.dimmer = {
    start: function(){
        $('.ui.dimmer').addClass('active');
    },
    stop: function(){
        $('.ui.dimmer').removeClass('active');
    }
}
