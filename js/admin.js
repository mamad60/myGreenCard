// copy image Address to clipboard
function copyToClipboard(element) {
    var url = $(element).prev('a').attr('href');
    var $temp = $('<input>');
    $('body').append($temp);
    $temp.val(url).select();
    document.execCommand('copy');
    $temp.remove();
    $(element).tooltip('show');
    setTimeout(function () {
        $(element).tooltip('hide');
    }, 1000);
}
var Model = {
    records: [{
        applicant: {},
        spouse: {},
        children: [{}]
    }],
    query_delete: function (recordID) {
        var dataSend = {
            function: 'query_delete',
            ID: recordID
        };
        $.ajax({
            url: 'scripts/ajaxphpfunctions.php',
            type: 'post',
            dataType: 'JSON',
            data: $.param(dataSend)
        }).done(function (response) {
            // Sucssessful
            if (!response.error) {
                if (View.totalRows > 1) {
                    View.reLoad(View.currentRow - 1);
                } else {
                    View.reLoad(0);
                }
                $('#adminSearchResult').text(response.message).removeClass('text-danger').addClass('text-success');
            } else {
                $('#adminSearchResult').text(response.message).removeClass('text-success').addClass('text-danger');
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            // console.error('The following error occurred: ' + textStatus,
            //     errorThrown);
            $('#adminSearchResult').text(
                'مشکلی در ارسال و دریافت اطلاعات رخ داده است.').removeClass('text-success').addClass('text-danger');
            return false;
        });
    },
    register: function (recordID) {
        var dataSend = {
            function: 'admin_register',
            ID: recordID,
            siteRegCode: $('#register #siteRegCode').val(),
        };
        if (Model.records[View.currentRow].applicant.spouseToo == '1') {
            dataSend.spouseSiteRegCode = $('#register #siteRegCodeSpouse').val();
        }
        $.ajax({
            url: 'scripts/ajaxphpfunctions.php',
            type: 'post',
            dataType: 'JSON',
            data: $.param(dataSend)
        }).done(function (response) {
            // Sucssessful
            if (!response.error) {
                $('#registerMessage').text('رکورد با موفقیت در دیتابیس ثبت نام شد').removeClass('Error').addClass('Success').show();
                $('#finalRegister').prop('disabled', true);
            } else {
                $('#registerMessage').text(response.message).removeClass('Success').addClass('Error').show();
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('#registerMessage').text('مشکلی در ارسال و دریافت اطلاعات رخ داده است').removeClass('Success').addClass('Error').show();
            return false;
        });

    }
};

var View = {
    currentRow: 0, // Index of Current Row startinf from 0
    totalRows: 0, //Total numbr of DB Rows Matched    
    init: function () {
        //initilize view
        // bind event to logout
        $('#logout').click(function () {
            $.post('scripts/ajaxphpfunctions.php', {
                'function': 'admin_logout'
            });
            // go back
            window.location.href = 'index.php';
        });
        // bind event to Serch Form Submit
        $('#searchSubmit').click(function () {
            // Fire off the request to form.php
            var dataSend = $('#searchForm').serialize();
            dataSend += '&function=admin_query';
            $.ajax({
                url: 'scripts/ajaxphpfunctions.php',
                type: 'post',
                dataType: 'JSON',
                data: dataSend
            }).done(function (response) {
                // Sucssessful
                if (!response.error) {
                    $('#adminSearchResult').text(response.message).removeClass(
                        'text-danger').addClass('text-success');
                    View.totalRows = response.totalRows;
                    Model.records = response.records;
                    View.lastRecord();
                } else {
                    $('#adminSearchResult').text(response.message).removeClass(
                        'text-success').addClass('text-danger');
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // Log the error to the console
                // console.error('The following error occurred: ' + textStatus,
                //     errorThrown);
                $('#adminSearchResult').text(
                    'مشکلی در ارسال و دریافت اطلاعات رخ داده است.').removeClass(
                    'text-success').addClass('text-danger');
                return false;
            });

        });
        $('#nextRecord,#nextRecord1').click(function () {
            View.nextRecord();
        });
        $('#prevRecord,#prevRecord1').click(function () {
            View.prevRecord();
        });
        $('#reLoad,#reLoad1').click(function () {
            View.reLoad('last');
        });
        $('#firstRecord,#firstRecord1').click(function () {
            View.firstRecord();
        });
        $('#lastRecord,#lastRecord1').click(function () {
            View.lastRecord();
        });
        $('#deleteRecord').click(function () {
            if (window.confirm('آیا واقعا مایل به حذف رکورد جاری از دیتابیس هستید؟'))
                Model.query_delete(Model.records[View.currentRow].applicant.ID);
        });
        //Register Button
        $('#registerRecord,#registerRecord1').click(function () {
            if (Model.records[View.currentRow].applicant.registered != 1) {
                View.register(View.currentRow);
            }
        });

        //initiate tooltip and activate it on sucessful copy}
        $('.imgCopy').tooltip({
            title: 'Copied',
            trigger: 'manual'
        });

        //Initiate Clipborad js for all text and tel inputs
        var clipboard = new Clipboard('.copy', {
            target: function (trigger) {
                return trigger.parentNode.parentNode.childNodes[1];
            }
        });
        //initiate tooltip and activate it on sucessful copy
        $('.copy').tooltip({
            title: 'Copied',
            trigger: 'manual'
        });
        clipboard.on('success', function (e) {
            $(e.trigger).tooltip('show');
            setTimeout(function () {
                $(e.trigger).tooltip('hide');
            }, 1500);
            e.clearSelection();
        });
    },
    reLoad: function (position) {
        // first:'first; ,last:'last' current:enter position:enter positon
        var dataSend = {
            function: 'query_fetch'
        };
        $.ajax({
            url: 'scripts/ajaxphpfunctions.php',
            type: 'post',
            dataType: 'JSON',
            data: $.param(dataSend)
        }).done(function (response) {
            // Sucssessful
            if (!response.error) {
                $('#adminSearchResult').text(response.message).removeClass('text-danger').addClass('text-success');
                View.totalRows = response.totalRows;
                Model.records = response.records;
                if (response.totalRows == 0) {
                    $('#resultForm').trigger('reset');
                    return;
                }
                // show record based on prarmeter
                switch (position) {
                    case 'first':
                        View.firstRecord();
                        break;
                    case 'last':
                        View.lastRecord(); // show last record
                        break;
                    default:
                        View.fillFields(parseInt(position) || 0);
                }
            } else {
                $('#adminSearchResult').text(response.message).removeClass('text-success').addClass('text-danger');
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            // console.error('The following error occurred: ' + textStatus,
            //     errorThrown);
            $('#adminSearchResult').text(
                'مشکلی در ارسال و دریافت اطلاعات رخ داده است.').removeClass('text-success').addClass('text-danger');
            return false;
        });
    },
    fillFields: function (index) {
        // Reset Form
        $('#resultForm').trigger('reset');
        // if Regform exits remove it
        if ($('#register').length) {
            $('#register').remove();
        }
        View.currentRow = index;
        View.updateFields(index);
        //Main Applicant
        //====Personal Info
        $('#mainFirstName_fa').val(Model.records[index].applicant.FirstName_fa);
        $('#mainLastName_fa').val(Model.records[index].applicant.LastName_fa);
        $('#mainFirstName_en').val(Model.records[index].applicant.FirstName_en);
        $('#mainLastName_en').val(Model.records[index].applicant.LastName_en);
        $('#mainGender').val(Model.records[index].applicant.Gender);
        $('#mainBirthDate').val(Model.records[index].applicant.BirthDate);
        $('#Georgian_mainBirthDate').val(Model.records[index].applicant.BirthDate_Georgian);
        $('#mainBirthCity').val(Model.records[index].applicant.BirthCity);
        $('#mainBirthCountry').val(Model.records[index].applicant.BirthCountry);
        //===picture
        $('#mainPhotoLink').attr('href', Model.records[index].applicant.PhotoURL);
        $('#mainPhoto').attr('src', Model.records[index].applicant.PhotoURL);
        //===Conatact Info

        $('#mainAddress').val(Model.records[index].applicant.Address);
        $('#mainZipCode').val(Model.records[index].applicant.ZipCode);
        $('#mainEmail').val(Model.records[index].applicant.Email);
        $('#mainTelNumber').val(Model.records[index].applicant.TelNumber);
        //===educaton
        $('#mainEducation').val(Model.records[index].applicant.Education);
        //=== Maridge
        $('#mainMaridgStatus').val(Model.records[index].applicant.MaridgStatus);
        $('#mainChildNumber').val(Model.records[index].applicant.ChildNumber);
        //Spouse
        if (Model.records[index].applicant.hasSpouse == '1') {
            // fill the records
            //====Personal Info
            $('#spouse').show();
            $('#spouseFirstName_fa').val(Model.records[index].spouse.FirstName_fa);
            $('#spouseLastName_fa').val(Model.records[index].spouse.LastName_fa);
            $('#spouseFirstName_en').val(Model.records[index].spouse.FirstName_en);
            $('#spouseLastName_en').val(Model.records[index].spouse.LastName_en);
            $('#spouseGender').val(Model.records[index].spouse.Gender);
            $('#spouseBirthDate').val(Model.records[index].spouse.BirthDate);
            $('#Georgian_spouseBirthDate').val(Model.records[index].spouse.BirthDate_Georgian);
            $('#spouseBirthCity').val(Model.records[index].spouse.BirthCity);
            $('#spouseBirthCountry').val(Model.records[index].spouse.BirthCountry);
            //===picture
            $('#spousePhotoLink').attr('href', Model.records[index].spouse.PhotoURL);
            $('#spousePhoto').attr('src', Model.records[index].spouse.PhotoURL);
            //show the children
        } else {
            $('#spouse').hide();
        }
        //children
        $('#children> [id^=child]:not(#childTemplate)').remove(); //remove form DOM        
        if (Model.records[index].applicant.hasChildren == '1') {
            //Create Childen and fill It
            View.creatFillChildren(index);
            $('#children').show();
        } else {
            $('#children').hide();
        }
    },
    nextRecord: function () {
        if (this.currentRow == this.totalRows - 1) { // nest record not exiests
            return;
        }
        if (this.currentRow == this.totalRows - 2) { //next record is last record
            this.toggleButtons('last');
        }

        if (this.currentRow == 0) { // next record is 1, enable all buttons
            this.toggleButtons('');
        }

        this.currentRow++;
        this.fillFields(this.currentRow);
    },
    prevRecord: function () {
        if (this.currentRow == 0) { // prev record not exists
            this.toggleButtons('first');
            return;
        }
        if (this.currentRow == 1) { // prev is first recored
            this.toggleButtons('first');
        }
        if (this.currentRow == this.totalRows - 1) { //prev  record is last-1 enale all buttons
            this.toggleButtons('');
        }
        this.currentRow--;
        this.fillFields(this.currentRow);
    },
    firstRecord: function () { // go to first record of the resutlt
        this.toggleButtons('first');
        this.fillFields(0);
    },
    lastRecord: function () { // got to last record of the resutlt
        this.toggleButtons('last');
        this.fillFields(this.totalRows - 1);
    },
    toggleButtons: function (position) { // Toggle button on ends
        switch (position) {
            case 'first': // all enabled exept go back
                //===enabled           
                $('#nextRecord,#nextRecord1').prop('disabled', false);
                $('#lastRecord,#lastRecord1').prop('disabled', false);
                //===disabled
                $('#prevRecord,#prevRecord1').prop('disabled', true);
                $('#firstRecord,#firstRecord1').prop('disabled', true);
                break;
            case 'last': // all execpt go forward
                //===enabled           
                $('#prevRecord,#prevRecord1').prop('disabled', false);
                $('#firstRecord,#firstRecord1').prop('disabled', false);
                //==disabled
                $('#nextRecord,#nextRecord1').prop('disabled', true);
                $('#lastRecord,#lastRecord1').prop('disabled', true);
                break;
            default: // enable all
                $('#prevRecord,#prevRecord1').prop('disabled', false);
                $('#firstRecord,#firstRecord1').prop('disabled', false);
                $('#nextRecord,#nextRecord1').prop('disabled', false);
                $('#lastRecord,#lastRecord1').prop('disabled', false);
        }
    },
    creatFillChildren: function (index) {
        // Create childen and fill it with associated DATA from DB
        var childNumber = parseInt(Model.records[index].applicant.ChildNumber);
        for (var childIndex = 0; childIndex < childNumber; childIndex++) {
            //==Add Childrens to the Form
            var num = String(childIndex + 1); // enumerating 
            var childName = '#child' + num;
            //===First check if a element already exits
            // create children
            var $child = $('#childTemplate').clone().attr('id', 'child' + num);
            $('<h4 ></h4>').html('مشخصات فرزند شماره' + ' ' + num).prependTo($child);
            $('#children').append($child).show();
            // fill date into the child
            //====Personal Info
            $(childName + ' #childFirstName_fa').val(Model.records[index].children[childIndex].FirstName_fa);
            $(childName + ' #childLastName_fa').val(Model.records[index].children[childIndex].LastName_fa);
            $(childName + ' #childFirstName_en').val(Model.records[index].children[childIndex].FirstName_en);
            $(childName + ' #childLastName_en').val(Model.records[index].children[childIndex].LastName_en);
            $(childName + ' #childGender').val(Model.records[index].children[childIndex].Gender);
            $(childName + ' #childBirthDate').val(Model.records[index].children[childIndex].BirthDate);
            $(childName + ' #Georgian_childBirthDate').val(Model.records[index].children[childIndex].BirthDate_Georgian);
            $(childName + ' #childBirthCity').val(Model.records[index].children[childIndex].BirthCity);
            $(childName + ' #childBirthCountry').val(Model.records[index].children[childIndex].BirthCountry);
            //===picture
            $(childName + ' #childPhotoLink').attr('href', Model.records[index].children[childIndex].PhotoURL);
            $(childName + ' #childPhoto').attr('src', Model.records[index].children[childIndex].PhotoURL);
            //Append children to DOM
        }

    },
    updateFields: function (index) {
        var yes = 'بلی';
        var no = 'خیر';
        $('#recordNumber,#recordNumber1').text('رکورد ' + String(index + 1) + ' ' + 'از' + ' ' + View.totalRows);
        //show mardige status
        if (Model.records[index].applicant.hasSpouse == '1') {
            $('#s_spouse').html(yes);
        } else {
            $('#s_spouse').html(no);
        }
        //number of childrens
        $('#s_childNum').html(Model.records[index].applicant.ChildNumber);
        //Spouse registration too
        if (Model.records[index].applicant.spouseToo == '1') {
            $('#s_spouseReg').html(yes);
        } else {
            $('#s_spouseReg').html(no);
        }
        //Registraitoin Status
        if (Model.records[index].applicant.registered == '1') {
            $('#s_registered').html(yes);
            // disable registration Buttons
            $('#registerRecord,#registerRecord1').prop('disabled', true);
        } else {
            $('#s_registered').html(no);
            //Enable Registriation Buttons
            $('#registerRecord,#registerRecord1').prop('disabled', false);
        }

    },
    register: function (index) {
        // if registration form already exists do nothing
        if ($('#register').length) {
            return;
        }
        // Show the registarin form
        var $register = $('#register-template').clone().attr('id', 'register').show().insertBefore('#searchForm');
        //rename registraiton button
        $register.find('#finalRegister-template').attr('id', 'finalRegister').show();
        //rename registration  message
        $register.find('#registerMessage-template').attr('id', 'registerMessage');
        //rename main applicant
        $register.find('#applicantReg-template').attr('id', 'applicantReg').show();
        // If applicant has spouse
        if (Model.records[index].applicant.hasSpouse == '1') {
            $register.find('#spouseReg-template').attr('id', 'spouseReg').show();
        }
        //If applicant has children
        if (Model.records[index].applicant.hasChildren == '1') {
            var childNumber = parseInt(Model.records[index].applicant.ChildNumber);
            $register.find('#childReg-template').attr('id', 'childReg').show();
            for (var i = 1; i <= childNumber; i++) {
                $('#childCheck-template').clone().attr('id', 'childCheck' + String(i)).appendTo('#childReg').show();
                $('#childCheck' + String(i) + ' span').text('فرزند شماره ' + String(i));

            }
        }

        //show registration box-applicant
        $register.find('#regCodes-template').attr('id', 'regCodes').show();
        $('#regCodes').find('#siteRegCode-template').attr('id', 'siteRegCode').show();
        // if the registration of the spouse is requested
        if (Model.records[index].applicant.spouseToo == '1') {
            // show the spouse confirmation
            $register.find('#spouseRegToo-template').attr('id', 'spouseRegToo').show();
            $('#spouseRegToo').find('#spouseTooCheck-template').attr('id', 'spouseTooCheck').show();
            //show the spouse registiran code
            $('#regCodes').find('#spouseRegCode-template').attr('id', 'spouseRegCode').show();
            $('#spouseRegCode').find('#siteRegCodeSpouse-template').attr('id', 'siteRegCodeSpouse').show();
        }
        // remove templates
        $register.find('[id$=template]').remove();
        // Final Record Registration
        $('#finalRegister').click(function () {
            $('#register .Error').removeClass('Error');
            $('#registerMessage').hide();
            // Check If all required checkboxes is checked
            if (($('#register input[type=checkbox]:checked').length == $('#register input[type=checkbox]').length) && $('#siteRegCode').val() != '' && $('#siteRegCodeSpouse').val() != '') {
                Model.register(Model.records[View.currentRow].applicant.ID);
            } else { // on Error
                $('#registerMessage').removeClass('Success').addClass('Error').text('لطفا مراحل مشخص شده با رنگ قرمز را انجام دهید').show();
                $('#register input[type=checkbox]:not(:checked)').parent().addClass('Error');
                if ($('#siteRegCode').val() == '') {
                    $('#siteRegCode').prev().addClass('Error');
                }
                if ($('#siteRegCodeSpouse').val() == '') {
                    $('#siteRegCodeSpouse').prev().addClass('Error');
                }
            }
        });


    }
};
//
$(document).ready(function () {
    //Load header 
    $('nav').load('menu.html');
    //initialize view
    View.init();
    View.reLoad('last'); // get query form DB and shoe the first record 
});