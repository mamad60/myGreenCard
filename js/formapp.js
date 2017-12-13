    //================Model==========================================
    var model = {
        applicant: {
            items: {
                FirstName_fa: '',
                LastName_fa: '',
                FirstName_en: '',
                LastName_en: '',
                Gender: '',
                BirthDate: '',
                BirthDate_Georgian: '',
                BirthCity: '',
                BirthCountry: '',
                Address: '',
                ZipCode: '',
                Email: '',
                TelNumber: '',
                Education: '',
                MaridgStatus: '',
                ChildNumber: 0,
                PhotoURL: '',
                Photouploaded: false,
                hasSpouse: false,
                hasChildren: false,
            },
            //==============Methods
            save: function () {
                // saves validated data after form sumbit for later use
                this.items.FirstName_fa = $('#mainFirstName_fa').val();
                this.items.LastName_fa = $('#mainLastName_fa').val();
                this.items.FirstName_en = $('#mainFirstName_en').val();
                this.items.LastName_en = $('#mainLastName_en').val();
                this.items.Gender = $('input[name="mainGender"]:checked').val();
                this.items.BirthCity = $('#mainBirthCity').val();
                this.items.BirthCountry = $('#mainBirthCountry').val();
                this.items.BirthDate = $('#mainBirthDate').val();
                this.items.Address = $('#mainAddress').val();
                this.items.ZipCode = $('#mainZipCode').val();
                this.items.Email = $('#mainEmail').val();
                this.items.TelNumber = $('#mainTelNumber').val();
                this.items.Education = $('#mainEducation option:selected').val();
                this.items.MaridgStatus = $('#mainMaridgStatus option:selected').val();
                this.items.ChildNumber = parseInt($('#mainChildNumber').val());
                //Convert and set Georgian BirthDate
                this.items.BirthDate_Georgian = model.toGeorgian(this.items.BirthDate);
                //set the status of haschildren and has wife
                if (this.items.MaridgStatus == 'Married') {
                    this.items.hasSpouse = true;
                } else {
                    this.items.hasSpouse = false;
                }
                if (this.items.ChildNumber > 0 && !isNaN(this.items.ChildNumber)) {
                    this.items.hasChildren = true;
                } else {
                    this.items.hasChildren = false;
                }
            }
        },
        spouse: {
            items: {
                FirstName_fa: '',
                LastName_fa: '',
                FirstName_en: '',
                LastName_en: '',
                Gender: '',
                BirthDate: '',
                BirthDate_Georgian: '',
                BirthCity: '',
                BirthCountry: '',
                PhotoURL: '',
                Photouploaded: false
            },
            //============methods
            save: function () {
                // saves validated data after form sumbit for later use
                this.items.FirstName_fa = $('#spouseFirstName_fa').val();
                this.items.LastName_fa = $('#spouseLastName_fa').val();
                this.items.FirstName_en = $('#spouseFirstName_en').val();
                this.items.LastName_en = $('#spouseLastName_en').val();
                this.items.Gender = $('input[name="spouseGender"]:checked').val();
                this.items.BirthCity = $('#spouseBirthCity').val();
                this.items.BirthCountry = $('#spouseBirthCountry').val();
                this.items.BirthDate = $('#spouseBirthDate').val();
                //Convert and set Georgian BirthDate
                this.items.BirthDate_Georgian = model.toGeorgian(this.items.BirthDate);
            }
        },
        children: {
            items: [],
            //===========Methods======================
            createChild: function () { // funciton to create each child
                var obj = {
                    FirstName_fa: '',
                    LastName_fa: '',
                    FirstName_en: '',
                    LastName_en: '',
                    Gender: '',
                    BirthDate: '',
                    BirthCity: '',
                    BirthCountry: '',
                    BirthDate_Georgian: '',
                    PhotoURL: '',
                    Photouploaded: false,
                };
                return obj;
            },
            save: function () {
                // Save children info into the Model
                model.children.items.forEach(function (item, index) {
                    var I = index + 1; //Skip template value            
                    item.FirstName_fa = $('input[name="childFirstName_fa"]').eq(I).val();
                    item.LastName_fa = $('input[name="childLastName_fa"]').eq(I).val();
                    item.FirstName_en = $('input[name="childFirstName_en"]').eq(I).val();
                    item.LastName_en = $('input[name="childLastName_en"]').eq(I).val();
                    item.Gender = $('input[name="childGender' + String(I) + '"]:checked').val();
                    item.BirthCity = $('input[name="childBirthCity"]').eq(I).val();
                    item.BirthCountry = $('input[name="childBirthCountry"]').eq(I).val();
                    item.BirthDate = $('input[name="childBirthDate' + String(I) + '"]').val();
                    //Convert and set Georgian BirthDate
                    item.BirthDate_Georgian = model.toGeorgian(model.children.items[index].BirthDate);
                });
            }
        },
        price: {
            single: 15000, // Charge for single Registrant
            spouse: 10000, // charge for spouse
            children: 5000, // charge for children
            totalCharge: 0, // total amout of charge applicable
            isPayed: false, // is the charge payed
            spouseToo: false, // Register spouse too with
            // ==Methods==>Calcutlate Charge
            calculateCharge: function () {
                var total = this.single;
                if (model.applicant.items.hasSpouse) {
                    total += this.spouse;
                }
                if (model.applicant.items.hasChildren) {
                    total += (model.applicant.items.ChildNumber) * (this.children);
                }
                if (model.price.spouseToo) {
                    total *= 1.5;
                }
                return total;
            }
        },
        TrackingCode: '',
        // ===Methods
        toGeorgian: function (jallaliDate) { //Convert date to Gerorgian
            if (!jallaliDate) {
                return '';
            }
            var jallali = jallaliDate.split('/');
            var georgian = toGregorian(parseInt(jallali[0]), parseInt(jallali[1]), parseInt(jallali[2]));
            return georgian.gy + '/' + georgian.gm + '/' + georgian.gd;
        },
        sendnSave: function () { //send data to server by ajax request and recive proce. ID
            // First Disable Payement and Sumbit Buttons
            $('#payandSubmit,#prevprevStage3,#prevStage3').attr('disabled', true);
            //Run the payment function-Ask for Payment
            // model.payment();
            // data to be send as Jsonn to the server
            //====Applicant Data
            var dataSent = {
                'Applicant': model.applicant.items
            };
            // ====Spouse Data
            if (model.applicant.items.hasSpouse) {
                dataSent.Spouse = model.spouse.items;
            }
            //===Children Data
            if (model.applicant.items.hasChildren) {
                dataSent.Children = model.children.items;
            }
            //====Payment Data
            dataSent.Price = {
                TotalCharge: model.price.totalCharge,
                SpouseToo: model.price.spouseToo
            };
            // Redirect and Post to payment Page
            $.redirect('payment.php', dataSent);

        }
    };
    //==============View==========================================================
    var view = {
        preStage: {
            show: function () {
                $('#progressBar li').eq(0).addClass('activeProgress');
                $('#preStageContainer').fadeIn('slow');
                $('#captchaString').focus();
            },
            next: function () {
                $('#preStageContainer').fadeOut('fast');
                view.firstStage.show();
            }
        },
        firstStage: {
            //-----Methods-------
            init: function () {
                //first initilize FileUpload Jquery Plugin
                $('#mainPhoto').fileinput({
                    language: 'fa',
                    rtl: true,
                    required: true,
                    uploadAsync: true,
                    uploadUrl: 'scripts/upload.php',
                    allowedFileExtensions: ['jpg', 'jpeg'],
                    allowedFileTypes: ['image'],
                    allowedPreviewTypes: ['image'],
                    maxFilePreviewSize: 240,
                    maxFileSize: 240,
                    maxFileCount: 1,
                    autoReplace: true,
                    msgPlaceholder: 'عکس پرسنلی خود را انتخاب کنید',
                    browseLabel: 'انتخاب فایل',
                    msgFileRequired: 'انتخاب حداقل یک  فایل برای آپلود الزامی است.',
                    uploadExtraData: {
                        fileName: 'mainPhoto'
                    },
                });

                // Event handler for succefull upload
                // Initilize Bootstrap form validator Plugin
                $('#mainApplicantForm')
                    .bootstrapValidator({
                        message: 'مقدار وارد شده مجاز نمی باشد.',
                        feedbackIcons: {
                            valid: 'fa fa-check fa-lg',
                            invalid: 'fa fa-times fa-lg',
                            validating: 'fa fa-refresh fa-lg fa-spin'
                        },
                        fields: {
                            mainFirstName_fa: {
                                message: 'نام وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainLastName_fa: {
                                message: 'نام خانوادگی وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام خانوادگی الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام خانوادگی باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainFirstName_en: {
                                message: 'نام وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[a-zA-Z0-9_\.]+$/,
                                        message: 'لطفا فقط از حروف انگلیسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainLastName_en: {
                                message: 'نام خانوادگی وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام خانوادگی الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام خانوادگی باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[a-zA-Z0-9_\.]+$/,
                                        message: 'لطفا فقط از حروف انگلیسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainGender: {
                                container: '#mainGenderErrors',
                                validators: {
                                    notEmpty: {
                                        message: 'انتخاب جنسیت الزامی است.'
                                    }
                                }
                            },
                            mainBirthDate: {
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن تاریخ تولد الزامی است.',
                                    },
                                    date: {
                                        format: 'YYYY/MM/DD',
                                        message: 'فرمت تاریخ وارد شده صحیح نمی باشد.',
                                    }
                                }
                            },
                            mainBirthCity: {
                                message: 'شهر وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام شهر تولد الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام شهر تولد باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainBirthCountry: {
                                message: 'کشور وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام کشور تولد الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام کشور تولد باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainAddress: {
                                message: 'آدرس وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن آدرس الزامی است.'
                                    },
                                    stringLength: {
                                        min: 10,
                                        max: 60,
                                        message: 'طول نام کشور تولد باید بین 10 و 60 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی,-_\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            mainZipCode: {
                                validators: {
                                    digits: {
                                        message: 'لطفا فقط از اعداداستفاده کنید.'
                                    },
                                    stringLength: {
                                        max: 16,
                                        message: 'حداکثر تعداد اعداد مجاز 16 عدداست.'
                                    },
                                }
                            },
                            mainTelNumber: {
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن شماره تلفن همراه الزامی است.'
                                    },
                                    digits: {
                                        message: 'لطفا فقط از اعداداستفاده کنید.'
                                    },
                                    stringLength: {
                                        min: 10,
                                        message: 'طول شماره تلفن باید حداقل 10 عددباشد.'
                                    },
                                }
                            },
                            mainEducation: {
                                validators: {
                                    notEmpty: {
                                        message: 'انتخاب سطح تحصیلات الزامی است.'
                                    },
                                }
                            },
                            mainChildNumber: {
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن تعداد فرزندان الزامی است.'
                                    },
                                    digits: {
                                        message: 'لطفا فقط از اعداداستفاده کنید.'
                                    },
                                }
                            },
                            mainEmail: {
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن آدرس  ایمیل الزامی است.'
                                    },
                                    emailAddress: {
                                        message: 'آدرس ایمیل وارد شده معتبر نیست.'
                                    },
                                }
                            },
                            mainMaridgStatus: {
                                validators: {
                                    notEmpty: {
                                        message: 'انتخاب وضعیت تاهل الزامی است'
                                    },
                                }
                            },
                        }
                    });
                // Event handler for succefull upload
                $('#mainPhoto').on('fileuploaded', function (event, data, previewId, index) {
                    model.applicant.items.Photouploaded = true;
                    model.applicant.items.PhotoURL = data.response.imageURL;
                    $(this).parents('.form-group').removeClass('has-error').addClass('has-feedback has-success');
                    $('#mainPhotoErrors').hide();
                });
                //Initilize Persian DateTime Picker
                $('#mainBirthDate').MdPersianDateTimePicker({
                    TargetSelector: '#mainBirthDate',
                    EnglishNumber: true
                });
                $('#mainBirthDate_AddOn').MdPersianDateTimePicker({
                    TargetSelector: '#mainBirthDate',
                    EnglishNumber: true
                });
                // Correct Validation
                $('#mainBirthDate').change(function () {
                    var bootstrapValidator = $('#mainApplicantForm').data('bootstrapValidator');
                    bootstrapValidator.revalidateField('mainBirthDate');
                });
            },
            render: function () {
                $('#firstStageContainer').slideDown('slow');
            },
            show: function () {
                // Change active Progress Bar
                $('.activeProgress').removeClass('activeProgress');
                $('#progressBar li').eq(1).addClass('activeProgress');
                this.render();
                // $('#mainApplicantForm *:input[type=text]:first').focus();
                $(window).scrollTop(0);
            },
            next: function () {
                // Save date
                model.applicant.save();
                // hide current form
                $('#firstStageContainer').fadeOut('slow');
                //Show the Next Stage
                view.secondStage.show();
            },
            isPhotosUploaded: function () {
                // Spouse photo
                var isUploaded = true;
                if (!model.applicant.items.Photouploaded) {
                    isUploaded = false;
                    $('#mainPhoto').parents('.form-group').removeClass('has-success').addClass('has-error');
                    $('#mainPhotoErrors').show();
                }
                return isUploaded;
            },
            reset: function () {
                //reset form exept the upload section
                $('#mainApplicantForm input[type="text"]').val('');
                $('#mainApplicantForm input[type="tel"]').val('');
                $('#mainApplicantForm input[type="email"]').val('');
                $('#mainApplicantForm textarea').val('');
                $('#mainApplicantForm input[type="radio"]').prop('checked', false);
                $('#mainApplicantForm select').val('').trigger('change');
                $('#mainApplicantForm option:disabled').prop('selected', true);
                // reset form validation
                $('#mainApplicantForm').data('bootstrapValidator').resetForm();
                $('#mainPhoto').parents('.form-group').removeClass('has-error');
                $('#mainPhotoErrors').hide();
                //reset Upload area
                $('#mainPhoto').fileinput('reset');
                // go to top of the page
                $(window).scrollTop(0);
            }
        },
        secondStage: {
            //-----Methods-------
            init: function () {
                // view=0: initiate spouse  view=1: initiate spouse 
                //initilize FileUpload Jquery Plugin for spouse
                $('#spousePhoto').fileinput({
                    language: 'fa',
                    rtl: true,
                    required: true,
                    uploadAsync: true,
                    uploadUrl: 'scripts/upload.php',
                    allowedFileExtensions: ['jpg', 'jpeg'],
                    allowedFileTypes: ['image'],
                    allowedPreviewTypes: ['image'],
                    maxFilePreviewSize: 240,
                    maxFileSize: 240,
                    maxFileCount: 1,
                    autoReplace: true,
                    msgPlaceholder: 'عکس پرسنلی همسر خود راانتخاب کنید',
                    browseLabel: 'انتخاب فایل',
                    msgFileRequired: 'انتخاب حداقل یک  فایل برای آپلود الزامی است.',
                    uploadExtraData: {
                        fileName: 'spousePhoto'
                    }
                });
                // Initiate Form Validation instance
                $('#spouseChildrenForm')
                    .bootstrapValidator({
                        message: 'مقدار وارد شده مجاز نمی باشد.',
                        feedbackIcons: {
                            valid: 'fa fa-check fa-lg',
                            invalid: 'fa fa-times fa-lg',
                            validating: 'fa fa-refresh fa-lg fa-spin'
                        },
                        fields: {
                            spouseFirstName_fa: {
                                message: 'نام وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            spouseLastName_fa: {
                                message: 'نام خانوادگی وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام خانوادگی الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام خانوادگی باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            spouseFirstName_en: {
                                message: 'نام وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[a-zA-Z0-9_\.]+$/,
                                        message: 'لطفا فقط از حروف انگلیسی استقاده نمائید.'
                                    }
                                }
                            },
                            spouseLastName_en: {
                                message: 'نام خانوادگی وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام خانوادگی الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام خانوادگی باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[a-zA-Z0-9_\.]+$/,
                                        message: 'لطفا فقط از حروف انگلیسی استقاده نمائید.'
                                    }
                                }
                            },
                            spouseGender: {
                                container: '#spouseGenderErrors',
                                validators: {
                                    notEmpty: {
                                        message: 'انتخاب جنسیت الزامی است.'
                                    }
                                }
                            },
                            spouseBirthDate: {
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن تاریخ تولد الزامی است.',
                                    },
                                    date: {
                                        format: 'YYYY/MM/DD',
                                        message: 'فرمت تاریخ وارد شده صحیح نمی باشد.',
                                    }
                                }
                            },
                            spouseBirthCity: {
                                message: 'شهر وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام شهر تولد الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام شهر تولد باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            },
                            spouseBirthCountry: {
                                message: 'کشور وارد شده صحیح نمی باشد',
                                validators: {
                                    notEmpty: {
                                        message: 'وارد کردن نام کشور تولد الزامی است.'
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 33,
                                        message: 'طول نام کشور تولد باید بین 3 و 33 حرف باشد'
                                    },
                                    regexp: {
                                        regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                                        message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                                    }
                                }
                            }
                        }
                    });
                //Initilize Persian DateTime Picker
                $('#spouseBirthDate').MdPersianDateTimePicker({
                    TargetSelector: '#spouseBirthDate',
                    EnglishNumber: true
                });
                $('#spouseBirthDate_AddOn').MdPersianDateTimePicker({
                    TargetSelector: '#spouseBirthDate',
                    EnglishNumber: true
                });
                // correct Date Validaiton
                $('#spouseBirthDate').change(function () {
                    var bootstrapValidator = $('#spouseChildrenForm').data('bootstrapValidator');
                    bootstrapValidator.revalidateField('spouseBirthDate');
                });
                // Event handler for succefull upload
                $('#spousePhoto').on('fileuploaded', function (event, data) {
                    model.spouse.items.Photouploaded = true;
                    model.spouse.items.PhotoURL = data.response.imageURL;
                    $(this).parents('.form-group').removeClass('has-error').addClass('has-feedback has-success');
                    $('#spousePhotoErrors').hide();
                });
            },
            render: function (viewIndex) {
                if (viewIndex == 0) { //show spouse
                    $('#spouse').show();
                }
                if (viewIndex == 1) { // show children
                    //===Add children Dynamically
                    var len = model.applicant.items.ChildNumber;
                    for (var index = 0; index < len; index++) {
                        //==Add Childrens to the Form
                        var num = String(index + 1); // enumerating                                       
                        //===First check if a element already exits
                        if (!$('#child' + num).length) {
                            var $child = $('#childTemplate').clone().attr('id', 'child' + num);
                            $('<h4 ></h4>').html('مشخصات فرزند شماره' + ' ' + num).prependTo($child);
                            $('<hr>').addClass('style-four').appendTo($child);
                            // ========Find and rename each date inputs
                            $child.find('#childDate').attr('id', 'childDate' + num);
                            $child.find('#childBirthDate_AddOn').attr('id', 'childBirthDate_AddOn' + num);
                            $child.find('#childBirthDate').attr('id', 'childBirthDate' + num)
                                .attr('name', 'childBirthDate' + num);
                            // ========Add and rename upload container
                            $child.find('#photoContainer').attr('id', 'photoContainer' + num);
                            $child.find('#childPhoto').attr('id', 'childPhoto' + num)
                                .attr('name', 'childPhoto' + num);
                            // Modify name and message container for gender
                            $child.find('[name=childGender]').attr('name', 'childGender' + num);
                            //==========Message Contaner for gender
                            $child.find('#childGenderErrors').attr('id', 'childGenderErrors' + num);
                            //==========Error Container for upload
                            $child.find('#childPhotoErrors').attr('id', 'childPhotoErrors' + num);
                            $child.appendTo('#children').show();
                            //===Initiate plugins
                            view.secondStage.initiatePlugins(num);
                            model.children.items.push(model.children.createChild());
                        }
                    }
                    view.secondStage.removeChilds();
                    // Show the childern
                    $('#children').show();
                }
            },
            show: function () {
                // Change active Progress Bar
                $('.activeProgress').removeClass('activeProgress');
                $('#progressBar li').eq(2).addClass('activeProgress');
                // Hide Spouse and All children by Default
                $('#spouse').hide();
                $('#children').hide();
                // Render page sections
                if (!model.applicant.items.hasSpouse && !model.applicant.items.hasChildren) {
                    // Skip to next stage
                    view.secondStage.next();
                    return;
                }
                if (model.applicant.items.hasSpouse) { // If applicant has spouse initiate & show it
                    view.secondStage.render(0);
                }
                if (model.applicant.items.hasChildren) { // If applicant has children initiate & show them
                    view.secondStage.render(1);
                } else { // If no children and already children exists in dom remove them
                    view.secondStage.removeChilds();
                }
                $('#secondStageContainer').slideDown('slow');
                $('#spouseChildrenForm *:input[type=text]:first').focus();
                $(window).scrollTop(0);

            },
            next: function () {
                // Save data
                if (model.applicant.items.hasSpouse) {
                    model.spouse.save();
                }
                if (model.applicant.items.hasChildren) {
                    model.children.save();
                }
                // hide current form
                $('#secondStageContainer').fadeOut('slow');
                //Show the Next Stage
                view.thirdStage.show();
            },
            prev: function () { // Show the privious stage
                // hide current form
                $('#secondStageContainer').fadeOut('slow');
                //Show the Next Stage
                view.firstStage.show();
            },
            initiatePlugins: function (num) {
                // Childern Numbering  Index & names)
                var childDate = 'childBirthDate' + num;
                var childGender = 'childGender' + num;
                var childGenderContainer = 'childGenderErrors' + num;
                var childPhoto = 'childPhoto' + num;
                //Initilize Persian DateTime Picker
                $('#' + childDate).MdPersianDateTimePicker({
                    TargetSelector: '#' + childDate,
                    EnglishNumber: true
                });
                $('#' + 'childBirthDate_AddOn' + num).MdPersianDateTimePicker({
                    TargetSelector: '#' + childDate,
                    EnglishNumber: true
                });
                //Correct Validaiton
                $('#' + childDate).change(function () {
                    var bootstrapValidator = $('#spouseChildrenForm').data('bootstrapValidator');
                    bootstrapValidator.revalidateField('#' + childDate);
                });
                //Initilize FileUpload Jquery Plugin for Children
                $('#' + childPhoto).fileinput({
                    language: 'fa',
                    rtl: true,
                    required: true,
                    uploadAsync: true,
                    uploadUrl: 'scripts/upload.php',
                    allowedFileExtensions: ['jpg', 'jpeg'],
                    allowedFileTypes: ['image'],
                    allowedPreviewTypes: ['image'],
                    maxFilePreviewSize: 240,
                    maxFileSize: 240,
                    maxFileCount: 1,
                    autoReplace: true,
                    msgPlaceholder: 'عکس پرسنلی فرزند خود راانتخاب کنید',
                    browseLabel: 'انتخاب فایل',
                    msgFileRequired: 'انتخاب حداقل یک  فایل برای آپلود الزامی است.',
                    uploadExtraData: {
                        fileName: childPhoto
                    }
                });
                //Add Date,Gender and photouplod to the form validation dynamically:
                // Add new fields
                //===Add Gender
                $('#spouseChildrenForm').bootstrapValidator('addField', childGender, {
                    container: '#' + childGenderContainer,
                    validators: {
                        notEmpty: {
                            message: 'انتخاب جنسیت الزامی است.'
                        }
                    }
                });
                //==Add Birthdate
                $('#spouseChildrenForm').bootstrapValidator('addField', childDate, {
                    validators: {
                        trigger: 'blur',
                        notEmpty: {
                            message: 'وارد کردن تاریخ تولد الزامی است.',
                        },
                        date: {
                            format: 'YYYY/MM/DD',
                            message: 'فرمت تاریخ وارد شده صحیح نمی باشد.',
                        }
                    }
                });
                //====Add Other Fields - add othe fields with the same name

                $('#spouseChildrenForm').bootstrapValidator('addField', 'childFirstName_fa', {
                    message: 'نام وارد شده صحیح نمی باشد',
                    validators: {
                        notEmpty: {
                            message: 'وارد کردن نام الزامی است.'
                        },
                        stringLength: {
                            min: 3,
                            max: 33,
                            message: 'طول نام باید بین 3 و 33 حرف باشد'
                        },
                        regexp: {
                            regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                            message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                        }
                    }
                });
                $('#spouseChildrenForm').bootstrapValidator('addField', 'childLastName_fa', {
                    message: 'نام خانوادگی وارد شده صحیح نمی باشد',
                    validators: {
                        notEmpty: {
                            message: 'وارد کردن نام خانوادگی الزامی است.'
                        },
                        stringLength: {
                            min: 3,
                            max: 33,
                            message: 'طول نام خانوادگی باید بین 3 و 33 حرف باشد'
                        },
                        regexp: {
                            regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                            message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                        }
                    }
                });
                $('#spouseChildrenForm').bootstrapValidator('addField', 'childFirstName_en', {
                    message: 'نام وارد شده صحیح نمی باشد',
                    validators: {
                        notEmpty: {
                            message: 'وارد کردن نام الزامی است.'
                        },
                        stringLength: {
                            min: 3,
                            max: 33,
                            message: 'طول نام باید بین 3 و 33 حرف باشد'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'لطفا فقط از حروف انگلیسی استقاده نمائید.'
                        }
                    }
                });
                $('#spouseChildrenForm').bootstrapValidator('addField', 'childLastName_en', {
                    message: 'نام خانوادگی وارد شده صحیح نمی باشد',
                    validators: {
                        notEmpty: {
                            message: 'وارد کردن نام خانوادگی الزامی است.'
                        },
                        stringLength: {
                            min: 3,
                            max: 33,
                            message: 'طول نام خانوادگی باید بین 3 و 33 حرف باشد'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'لطفا فقط از حروف انگلیسی استقاده نمائید.'
                        }
                    }
                });
                $('#spouseChildrenForm').bootstrapValidator('addField', 'childBirthCity', {
                    message: 'شهر وارد شده صحیح نمی باشد',
                    validators: {
                        notEmpty: {
                            message: 'وارد کردن نام شهر تولد الزامی است.'
                        },
                        stringLength: {
                            min: 3,
                            max: 33,
                            message: 'طول نام شهر تولد باید بین 3 و 33 حرف باشد'
                        },
                        regexp: {
                            regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                            message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                        }
                    }
                });
                $('#spouseChildrenForm').bootstrapValidator('addField', 'childBirthCountry', {
                    message: 'کشور وارد شده صحیح نمی باشد',
                    validators: {
                        notEmpty: {
                            message: 'وارد کردن نام کشور تولد الزامی است.'
                        },
                        stringLength: {
                            min: 3,
                            max: 33,
                            message: 'طول نام کشور تولد باید بین 3 و 33 حرف باشد'
                        },
                        regexp: {
                            regexp: /^[ئءاآبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/,
                            message: 'لطفا فقط از حروف فارسی استقاده نمائید.'
                        }
                    }
                });

                // Event handler for succefull upload for childs
                $('#' + childPhoto).on('fileuploaded', function (event, data) {
                    var i = parseInt($(this).attr('id').replace('childPhoto', '')) - 1;
                    model.children.items[i].Photouploaded = true;
                    model.children.items[i].PhotoURL = data.response.imageURL;
                    $(this).parents('.form-group').removeClass('has-error').addClass('has-feedback has-success');
                    $(('#childPhotoErrors' + String(i + 1))).hide();
                });
            },
            isPhotosUploaded: function () {
                // Spouse photo
                var isUploaded = true;
                if (model.applicant.items.hasSpouse) {
                    if (!model.spouse.items.Photouploaded) {
                        isUploaded = false;
                        $('#spousePhoto').parents('.form-group').removeClass('has-success').addClass('has-error');
                        $('#spousePhotoErrors').show();
                    }
                }
                if (model.applicant.items.hasChildren) {
                    for (var i = 0; i < model.applicant.items.ChildNumber; i++) {
                        if (!model.children.items[i].Photouploaded) {
                            isUploaded = false;
                            $('#childPhoto' + String(i + 1)).parents('.form-group').removeClass('has-success').addClass('has-error');
                            $('#childPhotoErrors' + String(i + 1)).show();
                        }
                    }
                }
                return isUploaded;
            },
            reset: function () {
                //reset form exept the upload section
                $('#spouseChildrenForm input[type="text"]').val('');
                $('#spouseChildrenForm input[type="tel"]').val('');
                $('#spouseChildrenForm input[type="email"]').val('');
                $('#spouseChildrenFormm textarea').val('');
                $('#spouseChildrenForm input[type="radio"]').prop('checked', false);
                // $('#spouseChildrenForm select').val('').trigger('change');
                $('#spouseChildrnForm option:disabled').prop('selected', true);
                // reset form validation
                $('#spouseChildrenForm').data('bootstrapValidator').resetForm();
                // reset Settings for Spouse
                if (model.applicant.items.hasSpouse) {
                    $('#spousePhoto').parents('.form-group').removeClass('has-error');
                    $('#spousePhotoErrors').hide();
                    //reset Upload area
                    $('#spousePhoto').fileinput('reset');
                }
                // reset setting for children
                if (model.applicant.items.hasChildren) {
                    for (var i = 0; i < model.applicant.items.ChildNumber; i++) {
                        var num = String(i + 1);
                        $('#childPhoto' + num).parents('.form-group').removeClass('has-error');
                        $('#childPhotoErrors' + num).hide();
                        //reset Upload area
                        $('#childPhoto' + num).fileinput('reset');
                    }
                }
                // go to top of the page
                $(window).scrollTop(0);

            },
            removeChilds: function () {
                var oldChild = $('#children').children().length - 2; //Number of all chils in DOM
                var diff = oldChild - model.applicant.items.ChildNumber; //Number of removed Elements
                if (diff > 0) {
                    for (var i = 0; i < diff; i++) {
                        $('#child' + String(oldChild - i)).remove(); //Remove Elements From DOM
                        model.children.items.pop();
                        // destroy instance of fileinput plugin
                        $('#childPhoto' + String(oldChild - i)).fileinput('destroy');
                    }
                }
            }
        },
        thirdStage: {
            render: function () {
                // Disable/Enable prev-prev based on status
                if (!(model.applicant.items.hasSpouse && model.applicant.items.hasChildren)) {
                    $('#prevStage3').attr('disabled', true);
                }
                if (model.applicant.items.hasSpouse || model.applicant.items.hasChildren) {
                    $('#prevStage3').attr('disabled', false);
                }
                this.renderPersonalInfo();
                if (model.applicant.items.hasSpouse) {
                    this.renderSpouseInfo();
                    $('#spouseReg').show();
                }
                if (model.applicant.items.hasChildren) {
                    this.renderChildrenInfo();
                }
                if (!model.price.isPayed) {
                    this.renderPrice();
                }

            },
            renderPersonalInfo: function () {
                // clone and rename template and remove Template from ID
                $('#personalInfoPanel-Template').clone().attr('id', 'personalInfoPanel').appendTo('#personalInfo');
                // Repalce place holders with form elements
                var $span = $('#personalInfoPanel .panel-body span'); // span jquery object--Faster
                // =======First name Farsi
                $span.eq(0).text($span.eq(0).text()
                    .replace('%FirstName_fa%', model.applicant.items.FirstName_fa));
                // =======Last name Farsi
                $span.eq(1).text($span.eq(1).text()
                    .replace('%LastName_fa%', model.applicant.items.LastName_fa));
                // =======First name English
                $span.eq(2).text($span.eq(2).text()
                    .replace('%FirstName_en%', model.applicant.items.FirstName_en));
                // =======Last name English
                $span.eq(3).text($span.eq(3).text()
                    .replace('%LastName_en%', model.applicant.items.LastName_en));
                // =======Gender
                $span.eq(4).text($span.eq(4).text()
                    .replace('%Gender%', $('input[name="mainGender"]:checked').parent().text()));
                //======BirthDate
                $span.eq(5).text($span.eq(5).text()
                    .replace('%BirthDate%', model.applicant.items.BirthDate));
                // =====BirthDay Georgian
                $span.eq(6).text($span.eq(6).text()
                    .replace('%BirthDate-Georgian%', model.applicant.items.BirthDate_Georgian));
                //=====Birth City
                $span.eq(7).text($span.eq(7).text()
                    .replace('%BirthCity%', model.applicant.items.BirthCity));
                //=====Birth Country
                $span.eq(8).text($span.eq(8).text()
                    .replace('%BirthCountry%', model.applicant.items.BirthCountry));
                //=====Zip Code
                $span.eq(9).text($span.eq(9).text()
                    .replace('%ZipCode%', model.applicant.items.ZipCode));
                //=====Email
                $span.eq(10).text($span.eq(10).text()
                    .replace('%Email%', model.applicant.items.Email));
                //======Tel Number
                $span.eq(11).text($span.eq(11).text()
                    .replace('%TelNumber%', model.applicant.items.TelNumber));
                //=====Education
                $span.eq(12).text($span.eq(12).text()
                    .replace('%Education%', $('#mainEducation option:selected').text()));
                //=====Mardige Status
                $span.eq(13).text($span.eq(13).text()
                    .replace('%MaridgStatus%', $('#mainMaridgStatus option:selected').text()));
                //=====Number of Children
                if (model.applicant.items.hasChildren) {
                    $span.eq(14).text($span.eq(14).text()
                        .replace('%ChildNumber%', model.applicant.items.ChildNumber));
                    $('#personalInfoPanel .panel-body .col-lg-4 ').eq(14).show();
                }
                //=====Adress
                $span.eq(15).text($span.eq(15).text()
                    .replace('%Address%', model.applicant.items.Address));
                //show the panel
                $('#personalInfoPanel').show();
            },
            renderSpouseInfo: function () {
                // clone and rename template and remove Template from ID
                $('#spouselInfoPanel-Template').clone().attr('id', 'spouseInfoPanel').appendTo('#spouseInfo');
                // Repalce place holders with form elements
                var $span = $('#spouseInfoPanel .panel-body span'); // span jquery object--Faster
                // =======First name Farsi
                $span.eq(0).text($span.eq(0).text()
                    .replace('%FirstName_fa%', model.spouse.items.FirstName_fa));
                // =======Last name Farsi
                $span.eq(1).text($span.eq(1).text()
                    .replace('%LastName_fa%', model.spouse.items.LastName_fa));
                // =======First name English
                $span.eq(2).text($span.eq(2).text()
                    .replace('%FirstName_en%', model.spouse.items.FirstName_en));
                // =======Last name English
                $span.eq(3).text($span.eq(3).text()
                    .replace('%LastName_en%', model.spouse.items.LastName_en));
                // =======Gender
                $span.eq(4).text($span.eq(4).text()
                    .replace('%Gender%', $('input[name="spouseGender"]:checked').parent().text()));
                //======BirthDate
                $span.eq(5).text($span.eq(5).text()
                    .replace('%BirthDate%', model.spouse.items.BirthDate));
                // =====BirthDay Georgian
                $span.eq(6).text($span.eq(6).text()
                    .replace('%BirthDate-Georgian%', model.spouse.items.BirthDate_Georgian));
                //=====Birth City
                $span.eq(7).text($span.eq(7).text()
                    .replace('%BirthCity%', model.spouse.items.BirthCity));
                //=====Birth Country
                $span.eq(8).text($span.eq(8).text()
                    .replace('%BirthCountry%', model.spouse.items.BirthCountry));
                //show the panel
                $('#spouseInfoPanel').show();
            },
            renderChildrenInfo: function () {
                // clone and rename template and remove Template from ID----> clone Outer Template
                $('#childernInfoPanel-Template').clone().attr('id', 'childernInfoPanel').appendTo('#childrenInfo');
                $('#childernInfoPanel #panelBody-Template').attr('id', 'panelBody');
                // adjust panel heading number
                if (model.applicant.items.hasSpouse) {
                    $('#childernInfoPanel .panel-heading').html('3- مشخصات فرزندان');
                } else {
                    $('#childernInfoPanel .panel-heading').html('2- مشخصات فرزندان');
                }
                // Iterate over childs and show their clientInformation.
                model.children.items.forEach(function (item, index) {
                    var I = String(index + 1); // Begin Numbering from 1       
                    var id = 'childInfo' + I;
                    $('#childInfo-Template').clone().attr('id', id).appendTo('#panelBody');
                    // Repalce place holders with form elements
                    //====Replace title with child Number
                    $('#' + id).find('.childHeading').html('<strong>' + 'اطلاعات فرزند شماره' + ' ' + I + ':' + '</strong>');
                    // Replace fileds
                    var $span = $('#' + id).find('span'); // span jquery object--Faster
                    // =======First name Farsi
                    $span.eq(0).text($span.eq(0).text()
                        .replace('%FirstName_fa%', item.FirstName_fa));
                    // =======Last name Farsi
                    $span.eq(1).text($span.eq(1).text()
                        .replace('%LastName_fa%', item.LastName_fa));
                    // =======First name English
                    $span.eq(2).text($span.eq(2).text()
                        .replace('%FirstName_en%', item.FirstName_en));
                    // =======Last name English
                    $span.eq(3).text($span.eq(3).text()
                        .replace('%LastName_en%', item.LastName_en));
                    // =======Gender
                    $span.eq(4).text($span.eq(4).text()
                        .replace('%Gender%', $('input[name="childGender' + I + '"]:checked').parent().text()));
                    //======BirthDate
                    $span.eq(5).text($span.eq(5).text()
                        .replace('%BirthDate%', item.BirthDate));
                    // =====BirthDay Georgian
                    $span.eq(6).text($span.eq(6).text()
                        .replace('%BirthDate-Georgian%', item.BirthDate_Georgian));
                    //=====Birth City
                    $span.eq(7).text($span.eq(7).text()
                        .replace('%BirthCity%', item.BirthCity));
                    //=====Birth Country
                    $span.eq(8).text($span.eq(8).text()
                        .replace('%BirthCountry%', item.BirthCountry));
                    $('#' + id).show();
                });
                //show the panel
                $('#childernInfoPanel').show();
            },
            renderPrice: function () {
                //first Calcultate and store price
                var price = 0;
                var spouse = '';
                var children = '';
                var has = '';
                var bp = '';
                var ep = '';
                var spouseToo = '';
                model.price.totalCharge = model.price.calculateCharge();
                price = model.price.totalCharge;
                if (model.applicant.items.hasSpouse || model.applicant.items.hasChildren) {
                    has = 'دارای ';
                    bp = '(';
                    ep = ')';
                }
                if (model.applicant.items.hasSpouse) {
                    spouse = 'همسر';
                }
                if (model.applicant.items.hasChildren) {
                    if (model.applicant.items.hasSpouse) {
                        children = ' و ';
                    }
                    children += model.applicant.items.ChildNumber + ' ' + 'فرزند';
                }
                if (model.price.spouseToo) {
                    spouseToo = ' و همسر متقاضی';
                }
                var message = 'هزینه ثبت نام در قرعه کشی گرین کارت برای فرد متقاضی' + ' ' + bp + has + spouse + children + ep + spouseToo + ' ' + '<strong>' + ' ' + price + ' ' + '</strong>' + 'تومان ' + 'میباشد.';
                $('#price').find('span').html(message);
                $('#price').show();
            },
            removePanels: function () { // Remove panels from Dom when going back in the Form
                $('#personalInfoPanel').remove();
                if ($('#spouseInfoPanel').length) {
                    $('#spouseInfoPanel').remove();
                }
                if ($('#childernInfoPanel').length) {
                    $('#childernInfoPanel').remove();
                }
                $('#price').hide();
            },
            show: function () {
                // Change active Progress Bar
                $('.activeProgress').removeClass('activeProgress');
                $('#progressBar li').eq(3).addClass('activeProgress');

                view.thirdStage.render();
                $('#thirdStageContainer').slideDown('slow');
            }, //===Previous  Stage 3--modify Spouse-Children info
            prev: function () {
                if (model.applicant.items.hasSpouse || model.applicant.items.hasChildren) {
                    $('#thirdStageContainer').hide();
                    this.removePanels();
                    view.secondStage.show();
                }
            }, //Previous-Previous  Stage 3--modify Personal info
            prevPrev: function () {
                $('#thirdStageContainer').hide();
                this.removePanels();
                view.firstStage.show();
            },
            next: function (success) {
                // Change active Progress Bar
                $('.activeProgress').removeClass('activeProgress');
                $('#progressBar li').eq(4).addClass('activeProgress');
                var $temp = $('#finalNotice');
                $('#thirdStageContainer').fadeOut();
                $('#finalStageContainer').fadeIn('slow');
                if (success) { // if all thing is OK
                    //Replace place holders with text
                    $temp.find('.panel-heading').css('background-color', 'green').css('background-image', 'linear-gradient(to bottom,lightgreen 0,green 100%)');
                    $temp.find('#result').text('ثبت نام شما با موفقیت انجام شد. پس از ثبت نام در سایت گرین کارت , در اسرع وقت تائیدیه ثبت نام و نتیجه نهایی  برای شما ارسال خواهد شد').removeClass(' text-error').addClass('text-success');
                    $temp.find('#transID').text('شماره تراکنش: ' + model.price.TransID);
                    $temp.find('#trackingCode').text('کد پیگیری: ' + model.TrackingCode);
                    $temp.find('#description').html('<p>لطفا اطلاعات بالا را برای مراجعات و پیگیری های بعدی حفظ نمائید</p><p> با تشکر از اعتماد شما</p>');
                } else {
                    $temp.find('.panel-heading').css('background-color', 'red').css('background-image', 'linear-gradient(to bottom,red 0,red 100%)');
                    $temp.find('#result').text('متاسفانه ما قادر به دریافت اطلاعات و ثبت نام شما نیستیم.').removeClass('text-success').addClass('text-danger');
                    if (model.price.TransID) {
                        $temp.find('#transID').text('شماره تراکنش: ' + model.price.TransID);
                        $temp.find('#description').text('برای اطلاعات بیشتر و پیگیری پرداخت لطفا با ما تماس بگیرید.');
                    }
                    if (model.TrackingCode) {
                        $temp.find('#trackingCode').text('کد پیگیری: ' + model.TrackingCode);
                        $temp.find('#description').text('لطفا چند دقیقه بعد دوباره تلاش کنید');
                    }
                }

            }

        },
        //========Methods==========
        init: function () {
            view.submitAttemps = 0; // Reset submit Attemps
            // Click events for submit button
            //==== Attatch event to submit button of stage 1
            $('#nextStage1').click(function () {
                // Get plugin instance
                var bootstrapValidator = $('#mainApplicantForm').data('bootstrapValidator');
                bootstrapValidator.validate();
                // if (view.firstStage.isPhotosUploaded() && bootstrapValidator.isValid()) {
                $('#firstStageError').hide();
                view.firstStage.next();
                // } else {
                //     $(window).scrollTop(0);
                //     $('#firstStageError').slideDown();
                // }
            });
            //==== Attatch event to submit button of stage 2
            $('#nextStage2').click(function () {
                // Get plugin instance
                var bootstrapValidator = $('#spouseChildrenForm').data('bootstrapValidator');
                bootstrapValidator.validate();
                // if (view.firstStage.isPhotosUploaded() && bootstrapValidator.isValid()) {
                $('#secondStageError').hide();
                view.secondStage.next();
                // } else {
                //     $(window).scrollTop(0);
                //     $('#secondStageError').slideDown();
                // }
            });
            //==== Attatch event PAY Botton---- stage 3
            $('#payandSubmit').click(function () {
                view.submitAttemps++;
                if (view.submitAttemps <= view.maxSubmitLimit) {
                    $('#finalStageError').hide();
                    model.sendnSave();
                } else {
                    view.thirdStage.next(false);
                }
            });
            //===Attacth event to Captcha Submit button
            $('#captchaSubmit').click(function () {
                var dataSend = {
                    reg_form_captcha: $('#captcha_code').val()
                };
                // Fire off the request to form.php
                var request = $.ajax({
                    url: 'scripts/securimage/captcha_check.php',
                    type: 'post',
                    dataType: 'JSON',
                    data: $.param(dataSend)
                });
                // Callback handler that will be called on success
                request.done(function (response) {
                    // Sucssess ful captcha 
                    if (!response.error.length) {
                        $('#captchaError').hide();
                        // show the first stage of the form
                        view.preStage.next();
                    } else {
                        $('#captchaError').show();
                    }
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) {
                    // Log the error to the console
                    console.error('The following error occurred: ' + textStatus, errorThrown);
                    $('#captchaError').show();
                    return false;
                });

            });
            // //=====Attatch event to New Captcha
            // $('#newCaptcha').click(function() {
            //     //Captcha renewal
            //     $('#captcha_image').prop('src', 'scripts/securimage/securimage_show.php?' + Math.random());
            //     $('#captcha_code').val('');
            //     $('#captcha_code').focus();
            //     $('#captchaError').hide();
            // });
            // on spouseToochange
            $('#spouseToo').change(function () {
                if ($('#spouseToo').prop('checked')) {
                    model.price.spouseToo = true;
                } else {
                    model.price.spouseToo = false;
                }
                view.thirdStage.renderPrice();

            });
            // Attatch event to privious buttons
            //==== Attatch event to previous button of stage 2
            $('#prevStage2').click(function () {
                view.secondStage.prev();
            });
            //===Previous-Previous  Stage 3--modify Personal info
            $('#prevprevStage3').click(function () {
                view.thirdStage.prevPrev();
            });
            //===Previous  Stage 3--modify Spouse-Children info
            $('#prevStage3').click(function () {
                view.thirdStage.prev();
            });
            // Attatch event to reset buttons
            // ===Reset Button of stage 1
            $('#resetStage1').click(function (e) {
                e.preventDefault();
                view.firstStage.reset();
            });
            // ===Reset Button of stage 2
            $('#resetStage2').click(function (e) {
                e.preventDefault();
                view.secondStage.reset();
            });
            //Print Button ---Stage 3
            $('#printResult').click(function (e) {
                $('#printTitle').show();
                window.print();
                $('#printTitle').hide();
            });

            // Disdable number of children if Single  maridge status selected
            $('#mainMaridgStatus').change(function (e) {
                var bootstrapValidator = $('#mainApplicantForm').data('bootstrapValidator');
                if ($('#mainMaridgStatus option:selected').val() == 'Single') {
                    //    disable number of children
                    bootstrapValidator.resetField('mainChildNumber', true);
                    $('#mainChildNumber').attr('disabled', true);
                    $('#mainChildNumber').val(0);
                } else {
                    bootstrapValidator.resetField('mainChildNumber', true);
                    $('#mainChildNumber').attr('disabled', false);
                }
            });
            // hide Error Container when click on icon
            $('#firstStageError>i,#secondStageError>i').click(function () {
                $(this).parent().fadeOut('slow');
            });

            // Call init function of Stages
            view.firstStage.init();
            view.secondStage.init();
        },
        show: function () {
            view.preStage.show();
        },
        maxSubmitLimit: 3, // Maximum form sumbission tries allowed
        submitAttemps: 0 // stores number of submit attemps
    };

    $(function () {
        // load contact us modal
        // $('#contactUs').load('contact-us.html');
        //Load header and Footer
        //======Navigation
        $('nav').load('menu.html', function () {
            //===make current Page Active
            $('#myNavbar').find('li a[href="' + window.location.pathname.split('/').pop() + '"]').parent().addClass('active');
        });
        //Set Session
        set_session('user', 1000 * 60 * 15); // check every 15 minutes
        //Initiate Views
        view.init();
        //Show the the form
        view.show();
    });