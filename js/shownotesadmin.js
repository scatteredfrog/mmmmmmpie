var notes_count = 0;
$(document).ready(function() {
    $('#add_notes_button').on('click',function() {
        $.post('shownotesadmin/login',{'username' : $('#user_name').val(), 'password': $('#password').val() }, function(data) {
            if (data === 'flirzelkwerp') {
                alert("INVALID LOGIN");
            } else {
                $('#add_notes_form').addClass('formVisible');
                $('#add_notes_login').removeClass('formVisible');
            }
        });
    });
    
    $('#password').on('keypress keydown keyup',function(e) {
        if (e.keyCode === 13) {
            $('#add_notes_button').trigger('click');
        }
    });
    
    $('#add_new_show_click').on('click',function() {
        $.post('shownotesadmin/getCurrentEpisode',{},function(data) {
            $('#episode_number').val(data);
        });
        $('#add_episode').css('display','block');
        $('[id^=desc]').each(function() {
            $(this).val('');
        });
        $('[id^=prior]').each(function() {
            $(this).val('');
        });
    });
    
    $('#log_out_click').on('click',function() {
        $.post('shownotesadmin/logOut',{},function() {
            $('#add_episode').css('display','none');
            $('#add_notes_form').removeClass('formVisible');
            $('#add_notes_login').addClass('formVisible');
        });
    });
    
    $('#click_to_add_notes').on('click',function() {
        if ($('#click_to_submit').css('display') !== 'none') {
            $.post('shownotesadmin/checkEpisode',  {
                    'episode_number' : $('#episode_number').val()
                }, function (data) {
                    if (data == '3') {
                        alert('That episode already exists!');
                        return;
                    } else {
                        addMoreNotes();
                    }
                }
            );
        } else {
            addMoreNotes();
        }
    });
    
    $('#click_to_submit').on('click',function() {
        var error = '';
        
        // ERROR CHECKING
        if (parseInt($('#episode_number').val()) < 0 || $('#episode_number').val() == '') {
            error += "Invalid episode number!\n";
        }
        if ($('#episode_topic').val().length < 1) {
            error += "Invalid topic!\n";
        }
        if ($('#download_link').val().substr(0,7) !== 'http://') {
            error += "Invalid download link!";
        }
        if (error !== '') {
            alert(error);
            return;
        } else {
            $.post('shownotesadmin/submit_episode', {
                    'episode_number' : $('#episode_number').val(),
                    'episode_topic'  : $('#episode_topic').val(),
                    'download_link'  : $('#download_link').val()
                },function(data) {
                    switch(data) {
                        case '3':
                            alert('That episode already exists!');
                            break;
                        case '0':
                            alert('There was a problem; that episode wasn\'t added.');
                            break;
                        case '1':
                            alert("Thanks! The episode has been added.");
                    }
                }
            );
        }
    });
    
    $('#click_to_submit_all').on('click',function() {
        var description = new Array();
        var description_link = new Array();
        var priority = new Array();
        $('[id^=description_]').each(function() {
            description.push($(this).val());
        });
        $('[id^=descriptionlink]').each(function() {
            description_link.push($(this).val());
        });
        $('[id^=priority]').each(function() {
            priority.push($(this).val());
        });
        $.post('shownotesadmin/checkEpisode',  {
                'episode_number' : $('#episode_number').val()
            }, function (data) {
                if (data == '3') {
                    alert('That episode already exists!');
                    return;
                } else {
                    $.post('shownotesadmin/submit_notes', {
                        'episode_number': $('#episode_number').val(),
                        'description': description,
                        'description_link': description_link,
                        'priority': priority,
                        'is_everything' : true,
                        'episode_topic' : $('#episode_topic').val(),
                        'download_link' : $('#download_link').val()
                    },function(data) {
                        switch(data) {
                            case '1':
                                alert("Thanks! Your show and show notes have been added.");
                                $('#add_episode').css('display','none');
                                $('input').each(function() {
                                    $(this).val('');
                                })
                                break;
                            case '2':
                                alert("There was a problem trying to add your show notes.");
                                break;
                            case '0':
                                alert("There was a problem adding that episode.");
                                break;
                            default:
                                alert("Thanks!");
                                $('#add_episode').css('display','block');
                                break;
                        }
                    });
                }
            }
        );
    });
});

function addMoreNotes() {
    if ($('#click_to_submit').css('display') !== 'none') {
        if ($('#add_episode_notes').css('display') !== 'block') {
            $('#add_episode_notes').css('display','block');
        }
        if ($('#click_to_submit').css('display') !== 'none') {
            $('#click_to_submit').css('display','none');
        }
        if ($('#click_to_submit_all').css('display') !== 'block') {
            $('#click_to_submit_all').css('display','block');
        }
    } else {
        notes_count++;
        if (notes_count >= 1) {
            $('#new_notes_container').append("<div class='formLabelRow'>Description: <input type='text' id='description_"+notes_count+"' /> Link: <input type='text' id='descriptionlink"+notes_count+"' /> Priority: <input type='number' id='priority"+notes_count+"' /></div>");
        }
    }
}