'use strict';
$(function () {
    $('#divInformation').hide();
    $('#showSurveyDeatils').hide();
    $.ajax({
        url: "controllers/page/survey-form.php?type=fetchCenterList",
        type: "GET",
        data: { survey: "CRSS" },
        contentType: false,
        processData: true,
        cache: false,
        success: function (dataResult) {
            let res = jQuery.parseJSON(dataResult);
            if (res.response == "SUCCESS") {
                let options = '<option value="">Select School</option>';
                res.data.forEach(element => {
                    options += `<option value="${element.code}">${element.name} ( ${element.code} )</option>`;
                });
                $('#cmbSchool').html('');
                $('#cmbSchool').append(options);
            } else {
                iziToast.info({
                    title: 'Error !',
                    message: 'Data Not Availble !',
                    position: 'topRight'
                });
            }
        },
    });
    $('#btnProceed').on('click', function () {
        $('#showSurveyDeatils').hide(200);
        if ($('#cmbSchool').val() != null && $('#cmbSchool').val() != '') {
            $('#showSurveyDeatils').hide(200);
            $.ajax({
                url: "controllers/page/survey-form.php?type=verifyCenter",
                type: "GET",
                data: { survey: "CRSS", center_code: $('#cmbSchool').val() },
                contentType: false,
                processData: true,
                cache: false,
                success: function (dataResult) {
                    let res = jQuery.parseJSON(dataResult);
                    if (res.response == "SUCCESS") {
                        console.log(res.data[0].is_surveyed);
                        if (res.data[0].is_surveyed == 0 || res.data[0].is_surveyed == '0') {
                            $('#spanSchoolName').html(res.data[0].name);
                            $('#spanSchoolCode').html(res.data[0].code);
                            $('#hdnSurveyCode').val(res.data[0].code);
                            $.ajax({
                                url: "controllers/page/survey-form.php?type=getQuestions",
                                type: "GET",
                                data: { survey: "CRSS" },
                                contentType: false,
                                processData: true,
                                cache: false,
                                success: function (dataResult) {
                                    let QuestionRes = jQuery.parseJSON(dataResult);
                                    if (QuestionRes.response == "SUCCESS") {
                                        let QuestionForm = '';
                                        if (QuestionRes.topic.length > 0) {
                                            // let x=1;
                                            QuestionRes.topic.forEach(TopicElement => {
                                            // if(x==1){
                                                QuestionForm += `<h3>${TopicElement.name}</h3>
                                                                <fieldset>
                                                                    <div class="">`;
                                                QuestionRes.sub_topic[TopicElement.code].forEach(SubTopicElement => {
                                                    QuestionForm += `<h5>${SubTopicElement.name}</h5>`;
                                                    QuestionRes.data[SubTopicElement.code].forEach(QuestionElement => {
                                                        QuestionForm += `<div class="form-group form-float form-line" style="padding-left: 20px;">
                                                                            <div class="section-title">${QuestionElement.question}</div>`;
                                                        let required = (QuestionElement.is_required == 1)?'required':'';
                                                        if(QuestionElement.question_type == 'MCQ2'){
                                                            QuestionForm += `<div class="custom-control custom-radio custom-control-inline ">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option1}" name="${QuestionElement.question_code}" value="${QuestionElement.option1}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option1}">${QuestionRes.option[QuestionElement.option1]}</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option2}" name="${QuestionElement.question_code}" value="${QuestionElement.option2}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option2}">${QuestionRes.option[QuestionElement.option2]}</label>
                                                                            </div>`;
                                                        } else if(QuestionElement.question_type == 'MCQ3'){
                                                            QuestionForm += `<div class="custom-control custom-radio custom-control-inline ">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option1}" name="${QuestionElement.question_code}" value="${QuestionElement.option1}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option1}">${QuestionRes.option[QuestionElement.option1]}</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option2}" name="${QuestionElement.question_code}" value="${QuestionElement.option2}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option2}">${QuestionRes.option[QuestionElement.option2]}</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option3}" name="${QuestionElement.question_code}" value="${QuestionElement.option3}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option3}">${QuestionRes.option[QuestionElement.option3]}</label>
                                                                            </div>`;
                                                        } else if(QuestionElement.question_type == 'MCQ4'){
                                                            QuestionForm += `<div class="custom-control custom-radio custom-control-inline ">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option1}" name="${QuestionElement.question_code}" value="${QuestionElement.option1}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option1}">${QuestionRes.option[QuestionElement.option1]}</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option2}" name="${QuestionElement.question_code}" value="${QuestionElement.option2}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option2}">${QuestionRes.option[QuestionElement.option2]}</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option3}" name="${QuestionElement.question_code}" value="${QuestionElement.option3}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option3}">${QuestionRes.option[QuestionElement.option3]}</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio" id="${QuestionElement.question_code}-${QuestionElement.option4}" name="${QuestionElement.question_code}" value="${QuestionElement.option4}" class="custom-control-input" ${required}>
                                                                                <label class="custom-control-label" for="${QuestionElement.question_code}-${QuestionElement.option4}">${QuestionRes.option[QuestionElement.option4]}</label>
                                                                            </div>`;
                                                        } else if(QuestionElement.question_type == 'Text'){
                                                            QuestionForm += `<div class="custom-group">
                                                                                <input type="text" id="${QuestionElement.question_code}" name="${QuestionElement.question_code}" class="custom-control" ${required}/>
                                                                            </div>`;
                                                        } else if(QuestionElement.question_type == 'Numeric'){
                                                            QuestionForm += `<div class="custom-group">
                                                                                <input type="number" pattern="[0-9]*" id="${QuestionElement.question_code}" name="${QuestionElement.question_code}" class="custom-control" ${required}/>
                                                                            </div>`;
                                                        }
                                                            QuestionForm += `</div></div>`;
                                                    });
                                                });
                                                QuestionForm += `</div>
                                                            </fieldset>`;
                                                // x++;
                                            // }
                                            });

                                            $('#divFilter').hide(200);
                                            $('#divInformation').show(200);
                                            $('#showSurveyDeatils').html(`<form id="wizard_with_validation" name="wizard_with_validation">${QuestionForm}</form>`);
                                            //Advanced form with validation
                                            var form = $('#wizard_with_validation').show();
                                            form.steps({
                                                headerTag: 'h3',
                                                bodyTag: 'fieldset',
                                                transitionEffect: 'slideLeft',
                                                onInit: function (event, currentIndex) {

                                                    //Set tab width
                                                    var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
                                                    var tabCount = $tab.length;
                                                    $tab.css('width', (100 / tabCount) + '%');

                                                    //set button waves effect
                                                    setButtonWavesEffect(event);
                                                },
                                                onStepChanging: function (event, currentIndex, newIndex) {
                                                    if (currentIndex > newIndex) { return true; }

                                                    if (currentIndex < newIndex) {
                                                        form.find('.body:eq(' + newIndex + ') label.error').remove();
                                                        form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                                                    }

                                                    form.validate().settings.ignore = ':disabled,:hidden';
                                                    return form.valid();
                                                },
                                                onStepChanged: function (event, currentIndex, priorIndex) {
                                                    setButtonWavesEffect(event);
                                                },
                                                onFinishing: function (event, currentIndex) {
                                                    form.validate().settings.ignore = ':disabled';
                                                    return form.valid();
                                                },
                                                onFinished: function (event, currentIndex) {
                                                    event.preventDefault();
                                                    var formData = new FormData(document.getElementById("wizard_with_validation"));
                                                    $.ajax({
                                                        url: `controllers/page/survey-form.php?type=saveSurvey&survey=CRSS&center_code=${$('#hdnSurveyCode').val()}`,
                                                        type: "POST",
                                                        data: formData,
                                                        contentType: false,
                                                        processData: false,
                                                        cache: false,
                                                        success: function (response) {
                                                            let resp = jQuery.parseJSON(response);
                                                            if (resp.response == "SUCCESS") {
                                                                alert(resp.message, "Submitted!", "success");
                                                                $('#showSurveyDeatils').hide(200);
                                                                $('#divInformation').hide(200);
                                                                $('#divFilter').show(200);
                                                            }else{
                                                                alert(resp.message, "Failed!", "error");
                                                            }
                                                        },
                                                        error: function (xhr, status, error) {
                                                            alert("Error: Try again later," + error);
                                                        }
                                                    });
                                                }
                                            });

                                            form.validate({
                                                highlight: function (input) {
                                                    $(input).parents('.form-line').addClass('error text-danger');
                                                },
                                                unhighlight: function (input) {
                                                    $(input).parents('.form-line').removeClass('error text-danger');
                                                },
                                                errorPlacement: function (error, element) {
                                                    $(element).parents('.form-group').append(error);
                                                },
                                                rules: {
                                                    'confirm': {
                                                        equalTo: '#password'
                                                    }
                                                }
                                            });
                                            $('#showSurveyDeatils').show(200);
                                        } else {
                                            alert('Topic Data Not Availble !');
                                        }
                                    } else {
                                        alert('Data Not Availble !');
                                    }
                                },
                            });
                        } else {
                            $('#showSurveyDeatils').html(`<h5><br><br>The survey for this school ${res.data[0].name} (UDISE Code: ${res.data[0].code}) was conducted on ${formatDate(res.data[0].survey_date)}.<br><br></h5>`);
                            $('#divInformation').hide(200);
                            $('#showSurveyDeatils').show(200);
                            $('#divFilter').show(200);
                        }
                    } else {
                        alert('Data Not Availble !');
                    }
                },
            });
        } else {
            alert('Please Select School before proceed !');
        }
    });
});

function setButtonWavesEffect(event) {
    $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
    $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = date.toLocaleString('en-US', { month: 'long' });
    const year = date.getFullYear();

    // Function to get ordinal suffix
    function getOrdinalSuffix(day) {
        if (day > 3 && day < 21) return 'th'; // Covers 4th-20th
        switch (day % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
            default: return 'th';
        }
    }

    return `${day}${getOrdinalSuffix(day)} ${month} ${year}`;
}
