var Model = {
    applicant: []
};

var View = {
    currentRow: 0, // Index of Current Row startinf from 0
    totalRows: 0, //Total numbr of DB Rows Matched    
    init: function() {
        //initilize view
        // bind event to logout
        $('#logout').click(function() {
            $.post('scripts/ajaxphpfunctions.php', {
                'function': 'admin_logout'
            });
            // go back
            window.location.href = 'index.php';
        });
        // bind event to Serch Form Submit
        $('#searchSubmit').click(function() {
            // Fire off the request to form.php
            var dataSend = $('#searchForm').serialize();
            dataSend += '&function=admin_query';
            $.ajax({
                url: 'scripts/ajaxphpfunctions.php',
                type: 'post',
                dataType: 'JSON',
                data: dataSend
            }).done(function(response) {
                // Sucssessful
                if (!response.error) {
                    $('#adminSearchResult').text(response.message).removeClass(
                        'text-danger').addClass('text-success');
                } else {
                    $('#adminSearchResult').text(response.message).removeClass(
                        'text-success').addClass('text-danger');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                // Log the error to the console
                // console.error('The following error occurred: ' + textStatus,
                //     errorThrown);
                $('#adminSearchResult').text(
                    'مشکلی در ارسال و دریافت اطلاعات رخ داده است.').removeClass(
                    'text-success').addClass('text-danger');
                return false;
            });
        });
        $('#nextRecord').click(function() {
            View.nextRecord();
        });
        $('#prevRecord').click(function() {
            View.prevRecord();
        });
        $('#reLoad').click(function() {
            View.reLoad();
        });
        $('#firstRecord').click(function() {
            View.firstRecord();
        });
        $('#lastRecord').click(function() {
            View.lastRecord();
        });

    },
    reLoad: function() {
        var dataSend = {
            function: 'query_fetch'
        };
        $.ajax({
            url: 'scripts/ajaxphpfunctions.php',
            type: 'post',
            dataType: 'JSON',
            data: $.param(dataSend)
        }).done(function(response) {
            // Sucssessful
            if (!response.error) {
                $('#adminSearchResult').text(response.message).removeClass('text-danger').addClass('text-success');
                View.totalRows = response.totalRows;
                Model.applicant = response.applicant;
                View.lastRecord(); // show last record
            } else {
                $('#adminSearchResult').text(response.message).removeClass('text-success').addClass('text-danger');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            // console.error('The following error occurred: ' + textStatus,
            //     errorThrown);
            $('#adminSearchResult').text(
                'مشکلی در ارسال و دریافت اطلاعات رخ داده است.').removeClass('text-success').addClass('text-danger');
            return false;
        });
    },
    fillFields: function(index) {
        $('#resultForm').trigger('reset');
        View.currentRow = index;
        $('#recordNumber').text('رکورد ' + String(View.currentRow + 1) + ' ' + 'از' + ' ' + View.totalRows);
        //====Personal Info
        $('#mainFirstName_fa').val(Model.applicant[index].FirstName_fa);
        $('#mainLastName_fa').val(Model.applicant[index].LastName_fa);
        $('#mainFirstName_en').val(Model.applicant[index].FirstName_en);
        $('#mainLastName_en').val(Model.applicant[index].LastName_en);
        $('#mainGender').val(Model.applicant[index].Gender);
        $('#mainBirthDate').val(Model.applicant[index].BirthDate);
        $('#Georgian_mainBirthDate').val(Model.applicant[index].BirthDate_Georgian);
        $('#mainBirthCity').val(Model.applicant[index].BirthCity);
        $('#mainBirthCountry').val(Model.applicant[index].BirthCountry);
        //===picture
        $('#mainPhotoLink').attr('href', Model.applicant[index].PhotoURL);
        $('#mainPhoto').attr('src', Model.applicant[index].PhotoURL);
        //===Conatact Info

        $('#mainAddress').val(Model.applicant[index].Address);
        $('#mainZipCode').val(Model.applicant[index].ZipCode);
        $('#mainEmail').val(Model.applicant[index].Email);
        $('#mainTelNumber').val(Model.applicant[index].TelNumber);
        //===educaton
        $('#mainEducation').val(Model.applicant[index].Education);
        //=== Maridge
        $('#mainMaridgStatus').val(Model.applicant[index].MaridgStatus);
        $('#mainChildNumber').val(Model.applicant[index].ChildNumber);




    },
    nextRecord: function() {
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
    prevRecord: function() {
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
    firstRecord: function() { // go to first record of the resutlt
        this.toggleButtons('first');
        this.fillFields(0);
    },
    lastRecord: function() { // got to last record of the resutlt
        this.toggleButtons('last');
        this.fillFields(this.totalRows - 1);
    },
    toggleButtons: function(position) { // Toggle button on ends
        switch (position) {
            case 'first': // all enabled exept go back
                //===enabled           
                $('#nextRecord').prop('disabled', false);
                $('#lastRecord').prop('disabled', false);
                //===disabled
                $('#prevRecord').prop('disabled', true);
                $('#firstRecord').prop('disabled', true);
                break;
            case 'last': // all execpt go forward
                //===enabled           
                $('#prevRecord').prop('disabled', false);
                $('#firstRecord').prop('disabled', false);
                //==disabled
                $('#nextRecord').prop('disabled', true);
                $('#lastRecord').prop('disabled', true);
                break;
            default: // enable all
                $('#prevRecord').prop('disabled', false);
                $('#firstRecord').prop('disabled', false);
                $('#nextRecord').prop('disabled', false);
                $('#lastRecord').prop('disabled', false);
        }
    }
};
$(document).ready(function() {
    //Load header 
    $('nav').load('menu.html');
    //initialize view
    View.init();
    View.reLoad(); // get query form DB and shoe the first record 
});