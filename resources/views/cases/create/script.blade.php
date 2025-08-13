<script>

    const submission = (section, form, submitButton) => {
        $.ajax({
            url: "{{ route('case.submission') }}",
            method: 'POST',
            data: {
                policy: currentCaseId,
                section: section,
                data: form,
                save: $(submitButton).data('type')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Saved successfully.',
                    allowOutsideClick: true, 
                    allowEscapeKey: true
                }).finally(() => {
                    if ('type' in response && response.type == 'save' && 'next_section' in response && response.next_section != '') {
                        var nextSection = $(submitButton).data('next');

                        if (!nextSection) return;

                        $('.case-section').removeClass('active');
                        $('#' + nextSection).addClass('active');

                        $('.case-submenu-item').removeClass('active');
                        $('.case-submenu-item[data-section="' + nextSection + '"]').addClass('active');

                        var $parentSidebarItem = $('.case-submenu-item[data-section="' + nextSection + '"]').closest('.case-sidebar-item');
                        $('.case-sidebar-item').removeClass('active').find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                        $parentSidebarItem.addClass('active').find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    } else if ('type' in response && response.type == 'draft') {
                        window.location.href = "{{ route('cases.index') }}";
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorList = '';

                    $.each(errors, function(key, messages) {
                        messages.forEach(function(message) {
                            errorList += `<li>${message}</li>`;
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Errors',
                        html: `<ul style="text-align: left;">${errorList}</ul>`
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            }
        });
    }

    /**
     * Handle form submission for section A-1
     **/
        const inputsa1 = document.querySelector('#section-a-1-phone_number');

        const itisa1 = window.intlTelInput(inputsa1, {
            initialCountry: "{{  Helper::getIso2ByDialCode($introducer['dial_code'] ?? null)  }}",
            separateDialCode:true,
            nationalMode:false,
            preferredCountries: @json(\App\Models\Country::select('iso2')->pluck('iso2')->toArray()),
            utilsScript: "{{ asset('assets/js/intel-tel-2.min.js') }}"
        });

        inputsa1.addEventListener("countrychange", function() {
            if (itisa1.isValidNumber()) {
                $('#section-a-1-dial_code').val(itisa1.s.dialCode);
            }
        });
        inputsa1.addEventListener('keyup', () => {
            if (itisa1.isValidNumber()) {
                $('#section-a-1-dial_code').val(itisa1.s.dialCode);
            }
        });

        $('#form-section-a-1').validate({
            rules: {
                section_a_1_name : {
                    required: true
                },
                section_a_1_email : {
                    required: true,
                    email: true
                },
                section_a_1_phone : {
                    required: true
                }
            },
            messages : {
                section_a_1_name : {
                    required: "Please enter the introducer's full name"
                },
                section_a_1_email : {
                    required: "Please enter the introducer's email address",
                    email: "Please enter a valid email address"
                },
                section_a_1_phone : {
                    required: "Please enter the introducer's contact number"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('id') === 'section-a-1-phone_number') {
                    error.insertAfter(element.parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                $('#section-a-1-dial_code').val(itisa1.s.dialCode);

                let formData = $(form).serializeArray().reduce((acc, item) => {
                    acc[item.name] = item.value;
                    return acc;
                }, {});

                let actionType = event.originalEvent.submitter;
                
                submission('section-a-1', formData, actionType);
            }
        });

    /**
     * Handle form submission for section A-1
     **/

    /**
     * Handle form submission for section A-2
     **/

        $('#form-section-a-2').validate({
        rules: {
            "policy_holder[name]": {
                required: true
            },
            "policy_holder[entity_type]": {
                required: true
            },
            "unsured_life[name]": {
                required: true
            },
            "unsured_life[entity_type]": {
                required: true
            },
            "beneficiaries[name]": {
                required: true
            },
            "beneficiaries[entity_type]": {
                required: true
            },
            "advisor[name]": {
                required: true
            },
            "advisor[entity_type]": {
                required: true
            },
            "idfm_holder[name]": {
                required: true
            },
            "idfm_holder[entity_type]": {
                required: true
            }
        },
        messages: {
            "policy_holder[name]": "Policyholder name is required",
            "policy_holder[entity_type]": "Policyholder entity type is required",
            "unsured_life[name]": "Insured life name is required",
            "unsured_life[entity_type]": "Insured life entity type is required",
            "beneficiaries[name]": "Beneficiary name is required",
            "beneficiaries[entity_type]": "Beneficiary entity type is required",
            "advisor[name]": "Advisor name is required",
            "advisor[entity_type]": "Advisor entity type is required",
            "idfm_holder[name]": "IDF Manager name is required",
            "idfm_holder[entity_type]": "IDF Manager entity type is required"
        },
            errorPlacement: function(error, element) {
                if (element.attr('id') === 'section-a-1-phone_number') {
                    error.insertAfter(element.parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                let formData = {};
                $(form).serializeArray().forEach(({ name, value }) => {
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
                
                let actionType = event.originalEvent.submitter;
                
                submission('section-a-2', formData, actionType);
            }
        });        

    /**
     * Handle form submission for section A-2
     **/
    

</script>