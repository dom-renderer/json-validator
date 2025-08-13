<script>
    let autoSaveTimers = {};
    let isSaving = {};
    let lastSavedData = {};

    function showSavingStatus(status, message = '') {
        const container = $('#saving-container');

        switch (status) {
            case 'saving':
                container.html(`
            <div class="saving-indicator">
                <div class="saving-spinner"></div>
                <span class="saving-text">Saving...</span>
            </div>
        `);
                break;
            case 'saved':
                container.html(`
            <div class="saved-indicator">
                <i class="fas fa-check-circle text-success"></i>
                <span class="saved-text">All changes saved at ${message}</span>
            </div>
        `);
                break;
            case 'error':
                container.html(`
            <div class="error-indicator">
                <i class="fas fa-exclamation-circle text-danger"></i>
                <span class="error-text">Error saving changes</span>
            </div>
        `);
                break;
        }
    }

    function collectFormData(sectionId) {
        const formData = {};
        const form = $(`#form-${sectionId}`);

        if (form.length) {

            if (sectionId == 'section-a-2' || sectionId == 'section-f-3' || sectionId == 'section-f-4' || sectionId ==
                'section-f-5' || sectionId == 'section-f-6' || sectionId == 'section-e-1') {
                $(form).serializeArray().forEach(({
                    name,
                    value
                }) => {
                    const keys = name.match(/[^\[\]]+/g);

                    keys.reduce((acc, key, i) => {
                        if (i === keys.length - 1) {
                            acc[key] = value;
                        } else {
                            acc[key] = acc[key] || {};
                        }
                        return acc[key];
                    }, formData);
                });
            } else {
                form.find('input, select, textarea').each(function() {
                    const $field = $(this);
                    const fieldName = $field.attr('name');
                    const fieldType = $field.attr('type');

                    if (fieldName) {
                        let value = '';

                        if (fieldType === 'radio') {
                            value = form.find(`input[name="${fieldName}"]:checked`).val() || '';
                        } else if (fieldType === 'checkbox') {
                            value = $field.is(':checked') ? $field.val() : '';
                        } else {
                            value = $field.val() || '';
                        }

                        formData[fieldName] = value;
                    }
                });

                form.find('select').each(function() {
                    const $select = $(this);
                    const selectId = $select.attr('id');
                    if (selectId && $select.hasClass('select2-hidden-accessible')) {
                        const select2Value = $select.select2('val');
                        if (select2Value) {
                            formData[`${selectId}_select2`] = select2Value;
                        }
                    }
                });
            }
        }

        return formData;
    }

    function hasDataChanged(sectionId) {
        const currentData = JSON.stringify(collectFormData(sectionId));
        const lastData = JSON.stringify(lastSavedData[sectionId] || {});
        return currentData !== lastData;
    }

    function performAutoSave(sectionId) {
        if (isSaving[sectionId] || !hasDataChanged(sectionId)) {
            return;
        }

        isSaving[sectionId] = true;
        showSavingStatus('saving');

        const formData = collectFormData(sectionId);
        const policyId = currentCaseId;

        $.ajax({
            url: '{{ route('case.auto-save') }}',
            type: 'POST',
            data: {
                policy: policyId,
                section: sectionId,
                data: formData,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    lastSavedData[sectionId] = formData;
                    showSavingStatus('saved', response.timestamp);
                } else {
                    showSavingStatus('error');
                }
            },
            error: function(xhr) {
                showSavingStatus('error');
            },
            complete: function() {
                isSaving[sectionId] = false;
            }
        });
    }

    function initAutoSave(sectionId, autoSaveDelay = 3000) {
        if (!autoSaveTimers[sectionId]) {
            autoSaveTimers[sectionId] = null;
        }
        if (!isSaving[sectionId]) {
            isSaving[sectionId] = false;
        }
        if (!lastSavedData[sectionId]) {
            lastSavedData[sectionId] = {};
        }

        $(document).on('input change',
            `#form-${sectionId} input, #form-${sectionId} select, #form-${sectionId} textarea`,
            function() {
                if (autoSaveTimers[sectionId]) {
                    clearTimeout(autoSaveTimers[sectionId]);
                }

                autoSaveTimers[sectionId] = setTimeout(function() {
                    performAutoSave(sectionId);
                }, autoSaveDelay);
            });

        $(document).on('select2:select select2:unselect', `#form-${sectionId} select`, function() {
            if (autoSaveTimers[sectionId]) {
                clearTimeout(autoSaveTimers[sectionId]);
            }

            autoSaveTimers[sectionId] = setTimeout(function() {
                performAutoSave(sectionId);
            }, autoSaveDelay);
        });

        lastSavedData[sectionId] = collectFormData(sectionId);
    }

    function handleFormSubmission(sectionId, saveType = 'draft') {
        if (autoSaveTimers[sectionId]) {
            clearTimeout(autoSaveTimers[sectionId]);
        }

        const formData = collectFormData(sectionId);
        const policyId = currentCaseId;

        $.ajax({
            url: '{{ route('case.submission') }}',
            type: 'POST',
            data: {
                policy: policyId,
                section: sectionId,
                save: saveType,
                data: formData,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.type === 'save' && response.next_section) {
                    $('.case-submenu-item[data-section="' + response.next_section + '"]').click();
                } else {
                    showSavingStatus('saved', new Date().toLocaleTimeString());
                }
            },
            error: function(xhr) {
                showSavingStatus('error');
            }
        });
    }

    $(document).ready(function() {
        initAutoSave('section-a-1');

        $('#form-section-a-1').on('submit', function(e) {
            e.preventDefault();
            const saveType = $(document.activeElement).data('type') || 'draft';
            handleFormSubmission('section-a-1', saveType);
        });

        $('.case-submenu-item').on('click', function() {
            const sectionId = $(this).data('section');

            if (!autoSaveTimers[sectionId]) {
                initAutoSave(sectionId);
            }

            $(`#form-${sectionId}`).off('submit').on('submit', function(e) {
                e.preventDefault();
                const saveType = $(document.activeElement).data('type') || 'draft';
                handleFormSubmission(sectionId, saveType);
            });
        });

        const sections = [
            'section-a-2', 'section-b-1', 'section-b-2', 'section-c-1',
            'section-d-1', 'section-e-1', 'section-e-2', 'section-e-3',
            'section-e-4', 'section-f-1', 'section-f-2', 'section-f-3',
            'section-f-4', 'section-f-5', 'section-f-6', 'section-f-7',
            'section-g-1', 'section-g-2'
        ];

        sections.forEach(function(sectionId) {
            if ($(`#form-${sectionId}`).length) {
                initAutoSave(sectionId);

                $(`#form-${sectionId}`).off('submit').on('submit', function(e) {
                    e.preventDefault();
                    const saveType = $(document.activeElement).data('type') || 'draft';
                    handleFormSubmission(sectionId, saveType);
                });
            }
        });
    });

    function triggerAutoSave(sectionId) {
        if (hasDataChanged(sectionId)) {
            performAutoSave(sectionId);
        }
    }

    function clearAutoSaveTimer(sectionId) {
        if (autoSaveTimers[sectionId]) {
            clearTimeout(autoSaveTimers[sectionId]);
            autoSaveTimers[sectionId] = null;
        }
    }
</script>

<script>
    let currentCaseId = "{{ $policy?->id }}";

    $(document).ready(function() {
        $('.each-options').click(function() {
            $('.case-section').addClass('d-none');

            var section = $(this).data('section');
            $(`#${section}`).removeClass('d-none');
        });
    });
</script>
{{-- Section C --}}
<script>
    $(document).ready(function() {
        $(document).on('click', '.section-b-1-add', function() {
            let newRow = `<div class="row mb-3 section-b-1-country-tax-residence-row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-7">
                <input type="text" class="form-control section-b-1-country-tax-residence">
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-success section-b-1-add">+</button>
                <button type="button" class="btn btn-danger section-b-1-remove">-</button>
            </div>
        </div>`;
            $('.section-b-1-country-tax-residence-row:last').after(newRow);
        });

        $(document).on('click', '.section-b-1-remove', function() {
            if ($('.section-b-1-country-tax-residence-row').length > 1) {
                $(this).closest('.section-b-1-country-tax-residence-row').remove();
            }
        });
    });
</script>
{{-- Section D --}}
<script>
    $(document).ready(function() {

        $('#section-b-2-country_id, #section-b-2-country_issuance, #section-b-2-country_legal_residence, .section-b-2-countries-tax')
            .select2({
                allowClear: true,
                placeholder: 'Select country',
                width: '100%',
                ajax: {
                    url: "{{ route('country-list') }}",
                    type: "POST",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchQuery: params.term,
                            page: params.page || 1,
                            _token: "{{ csrf_token() }}"
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.items, function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            }),
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

        $('#section-b-2-state_id').select2({
            allowClear: true,
            placeholder: 'Select state',
            width: '100%',
            ajax: {
                url: "{{ route('city-list') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchQuery: params.term,
                        page: params.page || 1,
                        state_id: $('#country_id').val(),
                        _token: "{{ csrf_token() }}"
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.items, function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            }
        });

        $('#section-b-2-city_id').select2({
            allowClear: true,
            placeholder: 'Select city',
            width: '100%',
            ajax: {
                url: "{{ route('city-list') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchQuery: params.term,
                        page: params.page || 1,
                        state_id: $('#state_id').val(),
                        _token: "{{ csrf_token() }}"
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.items, function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            }
        });

        $(document).on('click', '.section-b-2-add-tax', function() {
            var row = $(this).closest('.section-b-2-tax-residence-row').clone();
            row.find('select').val('').trigger('change');
            $('#section-b-2-tax-residence-wrapper').append(row);
        });

        $(document).on('click', '.section-b-2-remove-tax', function() {
            if ($('.section-b-2-tax-residence-row').length > 1) {
                $(this).closest('.section-b-2-tax-residence-row').remove();
            }
        });



    });
</script>
{{-- Section E 1 --}}
<script>
    $(document).ready(function() {
        $('#section-e-1-type').select2({
            allowClear: true,
            placeholder: 'Select Type',
            width: '100%'
        }).on('change', function() {
            let selectedValue = $('option:selected', this).val();

            $('.all-cbox').addClass('d-none');
            if (selectedValue) {
                $(`#container-for-ommit-documents-e1-${selectedValue}`).removeClass('d-none');
            }
        });
    });
</script>
{{-- Section F 1 --}}
<script>
    $(document).ready(function() {
        $('#s-f-1-purpose').select2({
            placeholder: 'Select Purpose',
            width: '100%'
        });

        $('#sg2-date').datepicker({
            dateFormat: 'yy-mm-dd',
            // maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0'
        });

        $('#sg1date').datepicker({
            dateFormat: 'yy-mm-dd',
            // maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0'
        });

        $('#f3d1').datepicker({
            dateFormat: 'yy-mm-dd',
            // maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0'
        });

        $('#f3d2').datepicker({
            dateFormat: 'yy-mm-dd',
            // maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0'
        });

        $('#f3d3').datepicker({
            dateFormat: 'yy-mm-dd',
            // maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0'
        });

        $('#dob').datepicker({
            dateFormat: 'yy-mm-dd',
            // maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0'
        });

        $('#policy_holder_id').select2({
            placeholder: 'Select Policy Holder',
            allowClear: true,
            width: '100%',
            ajax: {
                url: "{{ route('holder-list') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchQuery: params.term,
                        page: params.page || 1,
                        _token: "{{ csrf_token() }}",
                        roles: ['policy-holder'],
                        addNewOption: 1,
                        includeUserData: true
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data.items, function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }

                var $result = $('<span></span>');
                $result.text(data.text);
                return $result;
            }
        }).on('change', function() {

        });

        $('.section-b-1-country').select2({
            placeholder: 'Select Country',
            allowClear: true,
            width: '100%',
            ajax: {
                url: "{{ route('country-list') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchQuery: params.term,
                        page: params.page || 1,
                        _token: "{{ csrf_token() }}"
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data.items, function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }

                var $result = $('<span></span>');
                $result.text(data.text);
                return $result;
            }
        }).on('change', function() {
            $('.section-b-1-city').val(null).trigger('change');
        });

        $('.section-b-1-city').select2({
            placeholder: 'Select City',
            allowClear: true,
            width: '100%',
            ajax: {
                url: "{{ route('city-list') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchQuery: params.term,
                        page: params.page || 1,
                        _token: "{{ csrf_token() }}",
                        country_id: function() {
                            return $('.section-b-1-country option:selected').val();
                        }
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data.items, function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }

                var $result = $('<span></span>');
                $result.text(data.text);
                return $result;
            }
        });

        $(document).on('change', '.doc-upl', function() {
            let fileInput = $(this);
            let file = fileInput[0].files[0];
            let docId = fileInput.attr('name').match(/\d+/)[0];
            let viewBtn = $('#view\\[' + docId + '\\]');
            let chckBox = $('#doc-' + docId);
            let dtType = $('#doc-' + docId).data('type');

            if (!file) return;

            if (file.size > 10 * 1024 * 1024) {
                Swal.fire('Error', 'File size must be less than 10 MB', 'error');
                fileInput.val('');
                return;
            }

            let formData = new FormData();
            formData.append('file', file);
            formData.append('doc_id', docId);
            formData.append('policy_id', currentCaseId);
            formData.append('dt_type', dtType);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: "{{ route('upload-document') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while the file is uploading',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        Swal.fire('Success', 'File uploaded successfully', 'success');
                        viewBtn.removeClass('d-none').attr('href', response.url).attr(
                            'target', '_blank');

                        if (chckBox) {
                            chckBox.attr('checked', true)
                        }
                    } else {
                        Swal.fire('Error', response.message || 'Something went wrong',
                            'error');
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Server error while uploading file', 'error');
                }
            });
        });


    });
</script>
<script>
$(document).ready(function () {
    $('.policy-dropdown-toggle').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let $parentLi = $(this).closest('.child-dropdown');
        let $submenu = $parentLi.find('> .policy-dropdown-menu');

        $('.child-dropdown').not($parentLi).find('> .policy-dropdown-menu').slideUp();

        $submenu.stop(true, true).slideToggle();
    });

    $('.each-options').on('click', function (e) {
        e.preventDefault();
        let section = $(this).data('section');

        $('.each-options').removeClass('active');
        $(this).addClass('active');
    });
});
</script>
