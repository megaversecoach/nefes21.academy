jQuery(function ($) {
    'use strict'

    /**
     * ---------------------------------------
     * ------------- DOM Ready ---------------
     * ---------------------------------------
     */

    // Move the admin notices inside the appropriate div.
    $('.js-academyst-notice-wrapper').appendTo(
        '.js-academyst-admin-notices-container'
    )

    /**
     * ---------------------------------------
     * ------------- Events ------------------
     * ---------------------------------------
     */

    /**
     * No predefined demo import button click (manual import).
     */
    $('.js-academyst-start-manual-import').on('click', function (event) {
        event.preventDefault()

        var $button = $(this)

        if ($button.hasClass('academyst-button-disabled')) {
            return false
        }

        // Prepare data for the AJAX call
        var data = new FormData()
        data.append('action', 'academyst_upload_manual_import_files')
        data.append('security', academyst.ajax_nonce)

        if (
            $('#academyst__content-file-upload').length &&
            $('#academyst__content-file-upload').get(0).files.length
        ) {
            var contentFile = $('#academyst__content-file-upload')[0].files[0]
            var contentFileExt = contentFile.name.split('.').pop()

            if (-1 === ['xml'].indexOf(contentFileExt.toLowerCase())) {
                alert(academyst.texts.content_filetype_warn)

                return false
            }

            data.append('content_file', contentFile)
        }
        if (
            $('#academyst__widget-file-upload').length &&
            $('#academyst__widget-file-upload').get(0).files.length
        ) {
            var widgetsFile = $('#academyst__widget-file-upload')[0].files[0]
            var widgetsFileExt = widgetsFile.name.split('.').pop()

            if (-1 === ['json', 'wie'].indexOf(widgetsFileExt.toLowerCase())) {
                alert(academyst.texts.widgets_filetype_warn)

                return false
            }

            data.append('widget_file', widgetsFile)
        }
        if (
            $('#academyst__customizer-file-upload').length &&
            $('#academyst__customizer-file-upload').get(0).files.length
        ) {
            var customizerFile = $('#academyst__customizer-file-upload')[0]
                .files[0]
            var customizerFileExt = customizerFile.name.split('.').pop()

            if (-1 === ['dat'].indexOf(customizerFileExt.toLowerCase())) {
                alert(academyst.texts.customizer_filetype_warn)

                return false
            }

            data.append('customizer_file', customizerFile)
        }
        if (
            $('#academyst__redux-file-upload').length &&
            $('#academyst__redux-file-upload').get(0).files.length
        ) {
            var reduxFile = $('#academyst__redux-file-upload')[0].files[0]
            var reduxFileExt = reduxFile.name.split('.').pop()

            if (-1 === ['json'].indexOf(reduxFileExt.toLowerCase())) {
                alert(academyst.texts.redux_filetype_warn)

                return false
            }

            data.append('redux_file', reduxFile)
            data.append(
                'redux_option_name',
                $('#academyst__redux-option-name').val()
            )
        }

        $button.addClass('academyst-button-disabled')

        // AJAX call to upload all selected import files (content, widgets, customizer and redux).
        $.ajax({
            method: 'POST',
            url: academyst.ajax_url,
            data: data,
            contentType: false,
            processData: false,
        })
            .done(function (response) {
                if (response.success) {
                    window.location.href = academyst.import_url
                } else {
                    alert(response.data)
                    $button.removeClass('academyst-button-disabled')
                }
            })
            .fail(function (error) {
                alert(error.statusText + ' (' + error.status + ')')
                $button.removeClass('academyst-button-disabled')
            })
    })

    /**
     * Remove the files from the manual import upload controls (when clicked on the "cancel" button).
     */
    $('.js-academyst-cancel-manual-import').on('click', function () {
        $('.academyst__file-upload-container-items input[type=file]').each(
            function () {
                $(this).val('').trigger('change')
            }
        )
    })

    /**
     * Show and hide the file upload label and input on file input change event.
     */
    $(document).on(
        'change',
        '.academyst__file-upload-container-items input[type=file]',
        function () {
            var $input = $(this),
                $label = $input.siblings('label'),
                fileIsSet = false

            if (this.files && this.files.length > 0) {
                $input.removeClass('academyst-hide-input').blur()
                $label.hide()
            } else {
                $input.addClass('academyst-hide-input')
                $label.show()
            }

            // Enable or disable the main manual import/cancel buttons.
            $('.academyst__file-upload-container-items input[type=file]').each(
                function () {
                    if (this.files && this.files.length > 0) {
                        fileIsSet = true
                    }
                }
            )

            $('.js-academyst-start-manual-import').prop('disabled', !fileIsSet)
            $('.js-academyst-cancel-manual-import').prop('disabled', !fileIsSet)
        }
    )

    /**
     * Prevent a required plugin checkbox from changeing state.
     */
    $(
        '.academyst-install-plugins-content-content .plugin-item.plugin-item--required input[type=checkbox]'
    ).on('click', function (event) {
        event.preventDefault()

        return false
    })

    /**
     * Install plugins event.
     */
    $('.js-academyst-install-plugins').on('click', function (event) {
        event.preventDefault()

        var $button = $(this)

        if ($button.hasClass('academyst-button-disabled')) {
            return false
        }

        var pluginsToInstall = $(
            '.academyst-install-plugins-content-content .plugin-item input[type=checkbox]'
        ).serializeArray()

        if (pluginsToInstall.length === 0) {
            return false
        }

        $button.addClass('academyst-button-disabled')

        installPluginsAjaxCall(pluginsToInstall, 0, $button, false, false)
    })

    /**
     * Install plugins before importing event.
     */
    $('.js-academyst-install-plugins-before-import').on(
        'click',
        function (event) {
            event.preventDefault()

            var $button = $(this)

            if ($button.hasClass('academyst-button-disabled')) {
                return false
            }

            var pluginsToInstall = $(
                '.academyst-install-plugins-content-content .plugin-item:not(.plugin-item--disabled) input[type=checkbox]'
            ).serializeArray()

            if (pluginsToInstall.length === 0) {
                startImport(getUrlParameter('import'))
                return false
            }

            $button.addClass('academyst-button-disabled')

            installPluginsAjaxCall(pluginsToInstall, 0, $button, true, false)
        }
    )

    /**
     * Import the created content.
     */
    $('.js-academyst-create-content').on('click', function (event) {
        event.preventDefault()

        var $button = $(this)

        if ($button.hasClass('academyst-button-disabled')) {
            return false
        }

        var itemsToImport = $(
            '.academyst-create-content-content .content-item input[type=checkbox]'
        ).serializeArray()

        if (itemsToImport.length === 0) {
            return false
        }

        $button.addClass('academyst-button-disabled')

        createDemoContentAjaxCall(itemsToImport, 0, $button)
    })

    /**
     * Install the SeedProd plugin.
     */
    $('.js-academyst-install-coming-soon-plugin').on('click', function (event) {
        event.preventDefault()

        var $button = $(this),
            slug = 'coming-soon'

        if ($button.hasClass('button-disabled')) {
            return false
        }

        $button.addClass('button-disabled')

        $.ajax({
            method: 'POST',
            url: academyst.ajax_url,
            data: {
                action: 'academyst_install_plugin',
                security: academyst.ajax_nonce,
                slug: slug,
            },
            beforeSend: function () {
                $button.text(academyst.texts.installing)
            },
        })
            .done(function (response) {
                if (response.success) {
                    $button.text(academyst.texts.installed)
                } else {
                    alert(response.data)
                    $button.text(academyst.texts.install_plugin)
                    $button.removeClass('button-disabled')
                }
            })
            .fail(function (error) {
                alert(error.statusText + ' (' + error.status + ')')
                $button.removeClass('button-disabled')
            })
    })

    /**
     * Update "plugins to be installed" notice on Create Demo Content page.
     */
    $(document).on(
        'change',
        '.academyst--create-content .content-item input[type=checkbox]',
        function (event) {
            var $checkboxes = $(
                    '.academyst--create-content .content-item input[type=checkbox]'
                ),
                $missingPluginNotice = $(
                    '.js-academyst-create-content-install-plugins-notice'
                ),
                missingPlugins = []

            $checkboxes.each(function () {
                var $checkbox = $(this)
                if ($checkbox.is(':checked')) {
                    missingPlugins = missingPlugins.concat(
                        getMissingPluginNamesFromImportContentPageItem(
                            $checkbox.data('plugins')
                        )
                    )
                }
            })

            missingPlugins = missingPlugins.filter(onlyUnique).join(', ')

            if (missingPlugins.length > 0) {
                $missingPluginNotice
                    .find('.js-academyst-create-content-install-plugins-list')
                    .text(missingPlugins)
                $missingPluginNotice.show()
            } else {
                $missingPluginNotice
                    .find('.js-academyst-create-content-install-plugins-list')
                    .text('')
                $missingPluginNotice.hide()
            }
        }
    )

    /**
     * Grid Layout categories navigation.
     */
    ;(function () {
        // Cache selector to all items
        var $items = $('.js-academyst-gl-item-container').find(
                '.js-academyst-gl-item'
            ),
            fadeoutClass = 'academyst-is-fadeout',
            fadeinClass = 'academyst-is-fadein',
            animationDuration = 200

        // Hide all items.
        var fadeOut = function () {
            var dfd = jQuery.Deferred()

            $items.addClass(fadeoutClass)

            setTimeout(function () {
                $items.removeClass(fadeoutClass).hide()

                dfd.resolve()
            }, animationDuration)

            return dfd.promise()
        }

        var fadeIn = function (category, dfd) {
            var filter = category
                ? '[data-categories*="' + category + '"]'
                : 'div'

            if ('all' === category) {
                filter = 'div'
            }

            $items.filter(filter).show().addClass('academyst-is-fadein')

            setTimeout(function () {
                $items.removeClass(fadeinClass)

                dfd.resolve()
            }, animationDuration)
        }

        var animate = function (category) {
            var dfd = jQuery.Deferred()

            var promise = fadeOut()

            promise.done(function () {
                fadeIn(category, dfd)
            })

            return dfd
        }

        $('.js-academyst-nav-link').on('click', function (event) {
            event.preventDefault()

            // Remove 'active' class from the previous nav list items.
            $(this).parent().siblings().removeClass('active')

            // Add the 'active' class to this nav list item.
            $(this).parent().addClass('active')

            var category = this.hash.slice(1)

            // show/hide the right items, based on category selected
            var $container = $('.js-academyst-gl-item-container')
            $container.css('min-width', $container.outerHeight())

            var promise = animate(category)

            promise.done(function () {
                $container.removeAttr('style')
            })
        })
    })()

    /**
     * Grid Layout search functionality.
     */
    $('.js-academyst-gl-search').on('keyup', function (event) {
        if (0 < $(this).val().length) {
            // Hide all items.
            $('.js-academyst-gl-item-container')
                .find('.js-academyst-gl-item')
                .hide()

            // Show just the ones that have a match on the import name.
            $('.js-academyst-gl-item-container')
                .find(
                    '.js-academyst-gl-item[data-name*="' +
                        $(this).val().toLowerCase() +
                        '"]'
                )
                .show()
        } else {
            $('.js-academyst-gl-item-container')
                .find('.js-academyst-gl-item')
                .show()
        }
    })

    /**
     * Load/Close Popup for required plugin installation
     */
    ;(function () {
        $('.academy-import-button').on('click', function (event) {
            event.preventDefault()
            let demo = $(this).data('demo-index')

            $.ajax({
                url: academyst.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_required_plugin_popup',
                    security: academyst.ajax_nonce,
                    demo: demo,
                },
                success: function (responce) {
                    show_required_plugin_modal(responce.data, demo)
                },
            })
        })

        $('body').on(
            'click',
            '.required-plugin-modal-wrapper .modal-footer .btn.btn-outline',
            function () {
                $(this).closest('.required-plugin-modal-wrapper').remove()
            }
        )
    })()

    /**
     * Required plugin installation
     */
    ;(function () {
        $('body').on(
            'click',
            '.required-plugin-modal-wrapper .modal-footer .import-now',
            function (e) {
                e.preventDefault()
                var $button = $(this)
                var demo = $button.data('demo')
                $button
                    .closest('.required-plugin-modal-wrapper')
                    .find('h4')
                    .text('Installing Plugins')
                $button
                    .closest('.required-plugin-modal-wrapper')
                    .find('.header-spinner')
                    .addClass('plugin-item--loading')
                $button.siblings('.btn.btn-outline').hide()
                const plugins = []
                const not_installed = $button
                    .closest('.required-plugins')
                    .children('.not-installed')
                    .each(function () {
                        const plugin = []
                        plugin.name = $(this).data('slug')
                        plugin.value = 'on'
                        plugins.push(plugin)
                    })
                let installed = $button
                    .closest('.required-plugins')
                    .children('.installed')
                    .each(function () {
                        const plugin = []
                        plugin.name = $(this).data('slug')
                        plugin.value = 'on'
                        plugins.push(plugin)
                    })

                if (plugins.length === 0) {
                    startImport(demo)
                    return false
                }

                $button.addClass('academyst-button-disabled')

                installPluginsAjaxCall(plugins, 0, $button, true, false, demo)
            }
        )
    })()

    /**
     * ---------------------------------------
     * --------Helper functions --------------
     * ---------------------------------------
     */

    /**
     * The main AJAX call, which executes the import process.
     *
     * @param FormData data The data to be passed to the AJAX call.
     */
    function ajaxCall(data) {
        $.ajax({
            method: 'POST',
            url: academyst.ajax_url,
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.required-plugin-modal-wrapper')
                    .find('h4')
                    .text('Importing Contents')
                $('.required-plugin-modal-wrapper .demo-content')
                    .find('.spinner')
                    .addClass('spinner-show')
                $('.required-plugin-modal-wrapper')
                    .find('.importing-message')
                    .show()
                $('.required-plugin-modal-wrapper')
                    .find('.import-now')
                    .addClass('academyst-button-disabled')
            },
        })
            .done(function (response) {
                if (
                    'undefined' !== typeof response.status &&
                    'newAJAX' === response.status
                ) {
                    ajaxCall(data)
                } else if (
                    'undefined' !== typeof response.status &&
                    'customizerAJAX' === response.status
                ) {
                    // Fix for data.set and data.delete, which they are not supported in some browsers.
                    var newData = new FormData()
                    newData.append('action', 'academyst_import_customizer_data')
                    newData.append('security', academyst.ajax_nonce)

                    // Set the wp_customize=on only if the plugin filter is set to true.
                    if (true === academyst.wp_customize_on) {
                        newData.append('wp_customize', 'on')
                    }

                    ajaxCall(newData)
                } else if (
                    'undefined' !== typeof response.status &&
                    'afterAllImportAJAX' === response.status
                ) {
                    // Fix for data.set and data.delete, which they are not supported in some browsers.
                    var newData = new FormData()
                    newData.append('action', 'academyst_after_import_data')
                    newData.append('security', academyst.ajax_nonce)
                    ajaxCall(newData)
                } else if ('undefined' !== typeof response.message) {
                    $('.js-academyst-ajax-response').append(response.message)

                    if ('undefined' !== typeof response.title) {
                        $('.js-academyst-ajax-response-title').html(
                            response.title
                        )
                    }

                    if ('undefined' !== typeof response.subtitle) {
                        $('.js-academyst-ajax-response-subtitle').html(
                            response.subtitle
                        )
                    }
                    var modalwrapper = $('.required-plugin-modal-wrapper')
                    modalwrapper.find('h4').text('Importing Complete')
                    $('.required-plugin-modal-wrapper .demo-content')
                        .find('.spinner')
                        .removeClass('spinner-show')
                    $('.required-plugin-modal-wrapper')
                        .find('.importing-message')
                        .text('Your demo site is ready. Enjoy!!!')
                    $(
                        '.required-plugin-modal-wrapper .demo-content'
                    ).removeClass('demo-not-installed')
                    $('.required-plugin-modal-wrapper .demo-content').addClass(
                        'active'
                    )
                    modalwrapper
                        .find('.header-spinner')
                        .removeClass('plugin-item--loading')
                    modalwrapper.find('.import-now').hide()
                    modalwrapper.find('.btn-home-page').show()
                    // $( '.js-academyst-importing' ).hide();
                    // $( '.js-academyst-imported' ).show();

                    // Trigger custom event, when OCDI import is complete.
                    $(document).trigger('academystImportComplete')
                } else {
                    $('.js-academyst-ajax-response').append(
                        '<img class="academyst-imported-content-imported academyst-imported-content-imported--error" src="' +
                            academyst.plugin_url +
                            'assets/images/error.svg" alt="' +
                            academyst.texts.import_failed +
                            '"><p>' +
                            response +
                            '</p>'
                    )
                    $('.js-academyst-ajax-response-title').html(
                        academyst.texts.import_failed
                    )
                    $('.js-academyst-ajax-response-subtitle').html(
                        '<p>' + academyst.texts.import_failed_subtitle + '</p>'
                    )
                    $('.js-academyst-importing').hide()
                    $('.js-academyst-imported').show()
                }
            })
            .fail(function (error) {
                $('.js-academyst-ajax-response').append(
                    '<img class="academyst-imported-content-imported academyst-imported-content-imported--error" src="' +
                        academyst.plugin_url +
                        'assets/images/error.svg" alt="' +
                        academyst.texts.import_failed +
                        '"><p>Error: ' +
                        error.statusText +
                        ' (' +
                        error.status +
                        ')' +
                        '</p>'
                )
                $('.js-academyst-ajax-response-title').html(
                    academyst.texts.import_failed
                )
                $('.js-academyst-ajax-response-subtitle').html(
                    '<p>' + academyst.texts.import_failed_subtitle + '</p>'
                )
                $('.js-academyst-importing').hide()
                $('.js-academyst-imported').show()
            })
    }

    /**
     * Get the missing required plugin names for the Create Demo Content "plugins to install" notice.
     *
     * @param requiredPluginSlugs
     *
     * @returns {[]}
     */
    function getMissingPluginNamesFromImportContentPageItem(
        requiredPluginSlugs
    ) {
        var requiredPluginSlugs = requiredPluginSlugs.split(','),
            pluginList = []

        academyst.missing_plugins.forEach(function (plugin) {
            if (requiredPluginSlugs.indexOf(plugin.slug) !== -1) {
                pluginList.push(plugin.name)
            }
        })

        return pluginList
    }

    /**
     * Unique array helper function.
     *
     * @param value
     * @param index
     * @param self
     *
     * @returns {boolean}
     */
    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index
    }

    /**
     * The AJAX call for installing selected plugins.
     *
     * @param {Object[]} plugins             The array of plugin objects with name and value pairs.
     * @param {int}      counter             The index of the plugin to import from the list above.
     * @param {Object}   $button             jQuery object of the submit button.
     * @param {bool}     runImport           If the import should be run after plugin installation.
     * @param {bool}     pluginInstallFailed If there were any failed plugin installs.
     */
    function installPluginsAjaxCall(
        plugins,
        counter,
        $button,
        runImport,
        pluginInstallFailed,
        demo
    ) {
        var plugin = plugins[counter],
            slug = plugin.name

        $.ajax({
            method: 'POST',
            url: academyst.ajax_url,
            data: {
                action: 'academyst_install_plugin',
                security: academyst.ajax_nonce,
                slug: slug,
            },
            beforeSend: function () {
                var $currentPluginItem = $('.plugin-item-' + slug)
                $currentPluginItem.find('.spinner').addClass('spinner-show')
            },
        })
            .done(function (response) {
                var $currentPluginItem = $('.plugin-item-' + slug)
                $currentPluginItem.removeClass('not-installed')
                $currentPluginItem.removeClass('installed')

                if (response.success) {
                    $currentPluginItem.addClass('active')
                    $currentPluginItem
                        .find('.spinner')
                        .removeClass('spinner-show')
                    $currentPluginItem.find('.plugin-status').text('Active')
                } else {
                    // if ( -1 === response.data.indexOf( '<p>' ) ) {
                    // 	response.data = '<p>' + response.data + '</p>';
                    // }
                    $currentPluginItem
                        .find('.spinner')
                        .removeClass('spinner-show')
                    $currentPluginItem
                        .find('.plugin-status')
                        .append(response.data)
                    pluginInstallFailed = true
                }
            })
            .fail(function (error) {
                var $currentPluginItem = $('.plugin-item-' + slug)
                $currentPluginItem.find('.spinner').removeClass('spinner-show')
                $currentPluginItem
                    .find('.plugin-status')
                    .append(
                        '<p>' + error.statusText + ' (' + error.status + ')</p>'
                    )
                pluginInstallFailed = true
            })
            .always(function () {
                counter++
                if (counter === plugins.length) {
                    if (runImport) {
                        if (!pluginInstallFailed) {
                            startImport(demo)
                        } else {
                            $('.required-plugin-modal-wrapper')
                                .find('.header-spinner')
                                .removeClass('plugin-item--loading')
                            $('.required-plugin-modal-wrapper')
                                .find('.spinner')
                                .each(function () {
                                    $(this).removeClass('spinner-show')
                                })
                            $('.required-plugin-modal-wrapper')
                                .find('.btn.btn-outline')
                                .show()
                            $('.required-plugin-modal-wrapper')
                                .find('.import-now')
                                .hide()
                        }
                    }
                    // $button.removeClass('academyst-button-disabled')
                } else {
                    installPluginsAjaxCall(
                        plugins,
                        counter,
                        $button,
                        runImport,
                        pluginInstallFailed,
                        demo
                    )
                }
            })
    }

    /**
     * The AJAX call for importing content on the create demo content page.
     *
     * @param {Object[]} items The array of content item objects with name and value pairs.
     * @param {int}      counter The index of the plugin to import from the list above.
     * @param {Object}   $button jQuery object of the submit button.
     */
    function createDemoContentAjaxCall(items, counter, $button) {
        var item = items[counter],
            slug = item.name

        $.ajax({
            method: 'POST',
            url: academyst.ajax_url,
            data: {
                action: 'academyst_import_created_content',
                security: academyst.ajax_nonce,
                slug: slug,
            },
            beforeSend: function () {
                var $currentItem = $('.content-item-' + slug)
                $currentItem.find('.js-academyst-content-item-info').empty()
                $currentItem.find('.js-academyst-content-item-error').empty()
                $currentItem.addClass('content-item--loading')
            },
        })
            .done(function (response) {
                if (response.data && response.data.refresh) {
                    createDemoContentAjaxCall(items, counter, $button)
                    return
                }

                var $currentItem = $('.content-item-' + slug)

                $currentItem.removeClass('content-item--loading')

                if (response.success) {
                    $currentItem
                        .find('.js-academyst-content-item-info')
                        .append(
                            '<p>' + academyst.texts.successful_import + '</p>'
                        )
                } else {
                    $currentItem
                        .find('.js-academyst-content-item-error')
                        .append('<p>' + response.data + '</p>')
                }
            })
            .fail(function (error) {
                var $currentItem = $('.content-item-' + slug)
                $currentItem.removeClass('content-item--loading')
                $currentItem
                    .find('.js-academyst-content-item-error')
                    .append(
                        '<p>' + error.statusText + ' (' + error.status + ')</p>'
                    )
            })
            .always(function (response) {
                if (response.data && response.data.refresh) {
                    return
                }

                counter++

                if (counter === items.length) {
                    // $button.removeClass('academyst-button-disabled')
                } else {
                    createDemoContentAjaxCall(items, counter, $button)
                }
            })
    }

    /**
     * Get the parameter value from the URL.
     *
     * @param param
     * @returns {boolean|string}
     */
    function getUrlParameter(param) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=')

            if (sParameterName[0] === param) {
                return typeof sParameterName[1] === undefined
                    ? true
                    : decodeURIComponent(sParameterName[1])
            }
        }

        return false
    }

    /**
     * Run the main import with a selected predefined demo or with manual files (selected = false).
     *
     * Files for the manual import have already been uploaded in the '.js-academyst-start-manual-import' event above.
     */
    function startImport(selected) {
        // Prepare data for the AJAX call
        var data = new FormData()
        data.append('action', 'academyst_import_demo_data')
        data.append('security', academyst.ajax_nonce)

        if (selected) {
            data.append('selected', selected)
        }

        // AJAX call to import everything (content, widgets, before/after setup)
        ajaxCall(data)
    }

    function show_required_plugin_modal(data, demo) {
        let element_list = data
            .map((element) => {
                return (
                    '<div class="' +
                    element.status.replace(' ', '-') +
                    ' plugin-item-' +
                    element.slug +
                    '" data-slug="' +
                    element.slug +
                    '"><strong>' +
                    element.name +
                    '</strong> <span class="plugin-status">' +
                    element.status +
                    '</span><span class="spinner"></span></div>'
                )
            })
            .join('')

        let template = `<div class="required-plugin-modal-wrapper">
							<div class="modal-content">
								<div class="required-plugins">
									<div class="plugins-header">
										<h4>Required Plugins</h4><span class="header-spinner"></span>
									</div>
									<p class="plugins-description">The following plugins will be installed and activated for this demo if not already available:</p>
									${element_list}
									<div class="demo-not-installed demo-content">
										<strong>Demo Content</strong><span class="spinner"></span>
									</div>
									<div class="importing-message">Your content is importing.Depending on the content it may take 5-10 minutes.Please wait patiently.</div>
									<div class="modal-footer">
										<button class="btn btn-outline">Cancel</button>
										<button class="btn btn-primary import-now" data-demo="${demo}">Import Now</button>
										<a class="btn btn-primary btn-home-page" href="${academyst.site_url}">View Site</a>
									</div>
								</div>
							</div>
						</div>`

        document.body.insertAdjacentHTML('beforeend', template)
    }
})
