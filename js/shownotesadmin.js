var notes_count = ex_notes_count = 0;
$(document).ready(function() {
    
    $('#news_button').on('click touchstart', function() {
        var vd = "Please enter a valid date.";
        var errors = Array();
        var patt = /[0-9]{4}\/[0|1][0-9]\/[0-3][0-9]/g;
        if ($('#news_date').val() == '' || $('#news_headline').val() == '' || $("#news_article").val() == '') {
            alert("You need to fill out all three fields.");
            return false;
        } else if (!patt.test($('#news_date').val())) {
            alert(vd);
            return false;
        } else {
            var post_data = {
                'date' : $('#news_date').val(),
                'headline' : $('#news_headline').val(),
                'article' : $('#news_article').val()
            };        
            $.post('shownotesadmin/submitNews', post_data, function(data) {
                if (data == '1') {
                    $('[id^=news_]').val('');
                    alert("News item added successfully!");
                } else {
                    alert("Sorry, there was a problem.");
                }
            });
        }
    });
    
    $('#add_new_rating_submit').on('click touchstart', function() {
        $('#header_contact').css('display','none');
        $('.containerCenter').css('height','343px');
        var valid = true;
        $('#add_new_rating input').each(function() {
            if ($.trim($(this).val()).length < 1) {
                valid = false;
            }
        });
        if (valid) {
            var post_data = {
                'episodeNumber' : $('#add_ep_number').val(),
                'jim' : $('#add_jim_rating').val(),
                'sean' : $('#add_sean_rating').val(),
                'gameTitle': $('#add_game_title').val()
            };
            
            $.post('shownotesadmin/addNewRatings', post_data, function(data) {
                if (data) {
                    if (data == '1') {
                        alert("Rating added successfully.");
                        $('#add_new_rating input').each(function() {
                            $(this).val('');
                        });
                        $('#add_new_rating select').each(function() {
                            $(this).val('');
                        });
                        $('#add_new_rating').css('display','none');
                        $('#game_ratings_click').trigger('click');
                        $('#gamelist_dropdown_row').css('display', 'block');
                    } else if (data == '3') {
                        alert("That game's rating already exists.");
                    } else {
                        alert("There was a problem, chief.");
                    }
                }
            });
        }
    });
    
    $('#add_it').on('click touchstart', function() {
        $('#header_contact').css('display','none');
        $('#gamelist_dropdown_row').css('display', 'none');
        $('#add_new_rating').css('display','block');
    });
    
    $('#add_news_click').on('click touchstart', function() {
        $('#header_contact').css('display','none');
        $('.containerCenter').css('height','343px');
        $('.hideMe').css('display','none');
        $('#news').css('display', 'block');
    });
    
    $('#game_ratings_click').on('click touchstart', function() {
        $('.containerCenter').css('height','343px');
        $('#header_contact').css('display','none');
        $('.hideMe').css('display','none');
        $('#game_ratings').css('display', 'block');
        $.post('shownotesadmin/getGames', {}, function(data) {
            $('#game_dropdown').html(data);
        });
    });
    
    $('#add_notes_click').on('click touchstart',function() {
        $('#header_contact').css('display','none');
        $('.containerCenter').css('height','343px');
        $('.hideMe').css('display','none');
        $('#add_notes_to_existing').css('display','block');
        $.post('shownotesadmin/getEpisodes',{ 'section' : 'add'},function(data) {
            $('#existing_dropdown').html(data);
            $('#add_chooser').on('change',function() {
                $('.x').remove();
                $.post('shownotesadmin/getNotes', {
                    'episode' : $('#add_chooser').val(),
                    }, function(data) {
                        var sp = '<span class="episodeFz">';
                        var sl = '<span class="edLink">';
                        var si = '<span class="edPriority">';
                        var sc = '</span>';
                        var fr = '<div class="formLabelRow x">';
                        var fc = '</div>';
                        var s= ' &nbsp; ';
                        var jdata = JSON.parse(data);
                        var adata = [];
                        for (var x in jdata) {
                            adata.push(jdata[x]);
                        }
                        var ajlen = adata.length;
                        if (adata.length) {
                            row = fr;
                            row += sp + "DESCRIPTION" + sc;
                            row += sl + "LINK" + sc;
                            row += si + "PRIORITY" + sc;
                            row += fc;
                            $('#add_notes_to_existing_form').append(row);
                            for (var y = 0; y < ajlen; y++) {
                                if (adata[y]['description_link'] == "") {
                                    adata[y]['description_link'] = "(n/a)";
                                }
                                var row = "";
                                row += fr + sp + adata[y]['note'] + sc;
                                row += s + sl + adata[y]['description_link'] +sc;
                                row += s + si + adata[y]['priority'] + sc;
                                row += fc;
                                $('#add_notes_to_existing_form').append(row);
                            }
                        }
                        $('.delete').each(function() {
                            $(this).on('click', function() {
                                deleteNote($(this).attr('id'));
                            });
                        });
                        $('.update').each(function() {
                            $(this).on('click', function() {
                                updateNote($(this).attr('id'));
                            });
                        })
                    }
                );
            });
            $('#add_chooser').trigger('change');
        });
    });
    
    $('#add_notes_button').on('click touchstart',function() {
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
    
    $('#add_new_show_click').on('click touchstart',function() {
        $.post('shownotesadmin/getCurrentEpisode',{},function(data) {
            $('#episode_number').val(data);
        });
        $('.hideMe').css('display','none');
        $('#add_episode').css('display','block');
        $('[id^=desc]').each(function() {
            $(this).val('');
        });
        $('[id^=prior]').each(function() {
            $(this).val('');
        });
    });
    
    $('#unpublished_episodes_click').on('click touchstart', function() {
        $('#header_contact').css('display','none');
        $('.containerCenter').css('height','343px');
        $.post('shownotesadmin/getUnpublished', {}, function(data) {
            $('#unpublished_list').html(data);
        });
        $('.hideMe').css('display','none');
        $('#unpublished_episodes').css('display','block');
    });
    
    $('#log_out_click').on('click touchstart',function() {
        $.post('shownotesadmin/logOut',{},function() {
            $('.hideMe').css('display','none');
            $('#add_notes_form').removeClass('formVisible');
            $('#add_notes_login').addClass('formVisible');
        });
    });
    
    $('#click_to_add_notes').on('click touchstart',function() {
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
    
    $('#click_to_submit').on('click touchstart',function() {
        var error = '';
        
        // ERROR CHECKING
        if (parseInt($('#episode_number').val()) < 0 || $('#episode_number').val() == '') {
            error += "Invalid episode number!\n";
        }
        if ($('#episode_topic').val().length < 1) {
            error += "Invalid topic!\n";
        }
        if ($('#download_link').val().substr(0,7) !== 'http://') {
            error += "Invalid download link!\n";
        }
        if ($('#download_link').val().length < 8 && $('#publish').prop('checked')) {
            error += "Can't publish without a URL!";
        }
        if (error !== '') {
            alert(error);
            return;
        } else {
            $.post('shownotesadmin/submit_episode', {
                    'episode_number' : $('#episode_number').val(),
                    'episode_topic'  : $('#episode_topic').val(),
                    'download_link'  : $('#download_link').val(),
                    'publish_this_podcast' : $('#publish').prop('checked')
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
    
    $('#click_to_submit_all').on('click touchstart',function() {
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
    
    $('#edit_existing_notes_click').on('click touchstart',function() {
        $('#header_contact').css('display','none');
        $('.containerCenter').css('height','343px');
        $('.hideMe').css('display','none');
        $.post('shownotesadmin/getEpisodes',{},function(data) {
            $('#edit_notes_dropdown').html(data);
            $('#ed_chooser').on('change',function() {
                $('.x').remove();
                $.post('shownotesadmin/getNotes', {
                    'episode' : $('#ed_chooser').val()
                    }, function(data) {
                        var ip = '<input type="text" class="episodeFz" id="';
                        var il = '<input type="text" class="edLink" id="';
                        var ii = '<input type="number" class="edPriority" id="';
                        var ic = '" />';
                        var v = '" value="';
                        var dbt = ' &nbsp; <input type="button" class="delete" id="delete';
                        var dbi = '" value="Delete" />';
                        var ubt = ' &nbsp; <input type="button" class="update" id="update';
                        var ubi = '" value="Update" />';
                        var fr = '<div class="formLabelRow x">';
                        var fc = '</div>';
                        var s= ' &nbsp; ';
                        var jdata = JSON.parse(data);
                        var adata = [];
                        for (var x in jdata) {
                            adata.push(jdata[x]);
                        }
                        var ajlen = adata.length;
                        for (var y = 0; y < ajlen; y++) {
                            var row = "";
                            row += fr + ip + "ed_episode" + y + v + adata[y]['note'] + ic;
                            row += s + il + "ed_link" + y + v + adata[y]['description_link'] +ic;
                            row += s + ii + "ed_priority" + y + v + adata[y]['priority'] + ic;
                            row += dbt + adata[y]['id'] + dbi;
                            row += ubt + adata[y]['id'] + ubi;
                            row += fc;
                            $('#edit_notes_form').append(row);
                        }
                        $('.delete').each(function() {
                            $(this).on('click', function() {
                                deleteNote($(this).attr('id'));
                            });
                        });
                        $('.update').each(function() {
                            $(this).on('click', function() {
                                updateNote($(this).attr('id'));
                            });
                        })
                    }
                );
            });
        });
        $('#edit_notes').css('display','block');
    });
    
    $('#episode_select').on('click touchstart', function() {
        $('#ed_chooser').trigger('change');
    });
    
    $('#existing_select').on('click touchstart',function() {
        $('#add_chooser').trigger('change');
    });
    
    $('#add_more_existing_notes').on('click touchstart', function() {
        $('#add_existing_button').val("Add ALL notes");
        $("#add_notes_to_existing_form").append("<div class='formLabelRow'><input type='text' id='add_existing_note"+ex_notes_count+"' class='episodeFz' placeholder='Description' /> <input type='text' id='add_existing_desc_link"+ex_notes_count+"' placeholder='Link' class='edLink' /> <input type='number' id='add_existing_priority"+ex_notes_count+"' placeholder='Rank' class='edPriority' /></div>");
        ex_notes_count++;
    });
    
    $('#add_existing_button').on('click touchstart',function() {
        var add_description = [];
        var add_link = [];
        var add_priority = [];
        $('[id^=add_existing_note]').each(function () {
            add_description.push($(this).val());
        });
        $('[id^=add_existing_desc_link]').each(function () {
            add_link.push($(this).val());
        });
        $('[id^=add_existing_priority]').each(function () {
            add_priority.push($(this).val());
        });
        $.post('shownotesadmin/submit_notes', {
            'episode_number': $('#add_chooser option:selected').attr('id').substr(6),
            'description': add_description,
            'description_link': add_link,
            'priority': add_priority,
            'is_everything' : false,
            }, function(data) {
                switch(data) {
                    case '1':
                    case '3':
                        $('#existing_select').trigger('click');
                        break;
                    case '2':
                        alert("There was a problem adding the info to the database.");
                        break;
                    default:
                        alert("Hmmmm....");
                        break;
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

function deleteNote(item) {
    if(confirm("Deleting: "+  $('#'+item).parent().find('[id^=ed_episode]').val())) {
        var id = item.substr(6);
        $.post('shownotesadmin/deleteNote', { id: id }, function(data) {
            if (data) {
                $('#ed_chooser').trigger('change');
            }
        });
    }
}

function updateNote(item) {
    var id = item.substr(6);
    var note = $('#'+item).parent().find('[id^=ed_episode]').val();
    var description_link = $('#'+item).parent().find('[id^=ed_link]').val();
    var priority = $('#'+item).parent().find('[id^=ed_priority]').val();
    $.post('shownotesadmin/updateNote',
        {id : id, note: note, description_link: description_link, priority: priority},
        function(data) {
            if (data) {
                alert("Notes database has beeen updated successfully.");
            } else {
                alert("There was a problem; your note might not have been updated.");
            }
    });
       
}

function buttPub() {
    if ($('[id^="unpub_"]').filter(':checked').length < 1) {
        alert("But you haven't checked anything!");
    } else {
        var itemsToPublish = '';
        $('[id^="unpub_').each(function() {
            if ($(this).prop('checked')) {
                itemsToPublish += $(this).attr('id').substring(6) + '~';
            }
        });
        itemsToPublish = itemsToPublish.slice(0,-1);
        var post_data = { 'toPublish' : itemsToPublish };
        $.post('shownotesadmin/publishEpisodes', post_data, function() {
            $('#unpublished_episodes').css('display','none');
        });
    }
}

function changeRating() {
    $('#change_rating,.ratingVal').css('display','none');
    $('#submit_rating_change,.ratingEdit,.ratingSubmit').css('display','block');
}

function cancelRatingChange() {
    $('#change_rating,.ratingVal').css('display','block');
    $('#submit_rating_change,.ratingEdit,.ratingSubmit').css('display','none');
}

function submitRatingChange() {
    var post_data = {
        'id' : $('#game_chooser').val(),
        'jim' : $('#jim_rating').val(),
        'sean' : $('#sean_rating').val()
    };
    
    $.post('shownotesadmin/submitRatingsChange', post_data, function(data) {
        if (data) {
            alert('Rating successfully updated! woohoo!');
            cancelRatingChange();
            $('#gs_jim').text(post_data.jim);
            $('#gs_sean').text(post_data.sean);
        }
    });
}

function goGame() {
    cancelRatingChange();
    var post_data = {'id': $('#game_chooser').val()};
    $.post('shownotesadmin/showRatings', post_data, function(data) {
        $('#gs_name').text(data.game_title);
        $('#gs_jim').text(data.jim_rating);
        $('#jim_rating').val(data.jim_rating);
        $('#gs_sean').text(data.sean_rating);
        $('#sean_rating').val(data.sean_rating);
        $('#gs_episode').text(data.episode_number+ ': ' + data.episode_topic);
        $('#game_id').val(data.id);
        $('#game_stats').css('display','block');
    },'json');
}