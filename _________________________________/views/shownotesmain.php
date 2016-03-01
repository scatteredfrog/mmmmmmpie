<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pie Factory Podcast Show Notes Admin Page</title>

<?php
    echo link_tag('css/pfp_main.css');
?>
    <script src=<?=base_url("js/jquery-1.9.1.min.js"); ?>></script>
</head>
<body>
    <div class="containerCenter">
        <div class="headerWrapper">
            <div id="header_image">
                <div id="game_ratings" class="hideMe">
                    <form id="game_ratings_form">
                        <div id="game_list">
                            <div class="formLabelRow"></div>
                            <div class="formLabelRow" id="gamelist_dropdown_row">
                                <span id="game_dropdown"></span>
                                <button type="button" id="choose_game" onclick="goGame()">GO</button>
                            </div>
                            <div class="formLabelRow">
                                <span class="bold">Game not listed? 
                                    <button type="button" id="add_it">Add it!</button>
                                </span>
                            </div>
                            <div class="formLabelRow" id="add_new_rating">
                                Game title: <input type="text" id="add_game_title" /> * 
                                Jim's rating: 
                                <select id="add_jim_rating">
                                    <option value="0">n/a</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select> * 
                                Sean's rating: 
                                <select id="add_sean_rating">
                                    <option value="0">n/a</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <br />&nbsp;<br />
                                Episode number: 
                                <input type="number" id="add_ep_number" />
                                <button type="button" id="add_new_rating_submit">Submit</button>
                            </div>
                            <hr />
                            <div class="formLabelRow"></div>
                            <div class="formLabelRow"></div>
                            <div class="formLabelRow">
                                <div id="game_stats">
                                    <div class="formLabelRow">
                                        <div class="gameHeading">Game:</div>
                                        <div id="gs_name" class="gameVal"></div>
                                    </div>
                                    <div class="formLabelRow">
                                        <div class="gameHeading">Jim's rating:</div>
                                        <div id="gs_jim" class="gameVal ratingVal"></div>
                                        <div class="gameVal ratingEdit"><input id="jim_rating" type="number" max="5" min="0" /></div>
                                    </div>
                                    <div class="formLabelRow">
                                        <div class="gameHeading">Sean's rating:</div>
                                        <div id="gs_sean" class="gameVal ratingVal"></div>
                                        <div class="gameVal ratingEdit"><input id="sean_rating" type="number" max="5" min="0" /></div>
                                    </div>
                                    <div class="formLabelRow">
                                        <div class="gameHeading">Episode:</div>
                                        <div id="gs_episode" class="gameVal"></div>
                                    </div>
                                    <div class="formLabelRow">
                                        <button type="button" id="change_rating" class="ratingButton" onclick="changeRating()">Change Rating</button>
                                        <button type="button" id="cancel_rating_change" class="ratingButton ratingSubmit" onclick="cancelRatingChange()">Cancel Rating Change</button>
                                        <button type="button" id="submit_rating_change" class="ratingButton ratingSubmit" onclick="submitRatingChange()">Submit Rating Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="unpublished_episodes" class="hideMe">
                    <form id="unpublished_form">
                        <div id="unpublished_list">
                        </div>
                    </form>
                </div>
                <div id="add_notes_to_existing" class="hideMe">
                    <div class="formLabelRow" id="existing_label">
                        <div class="labelDivWide">Select an episode:</div>
                        <span id="existing_dropdown"></span>
                        <input type="button" id="existing_select" value="GO!" />
                    </div>
                    <div class="formLabelRow">
                        <input type="button" value="Add More Notes" id="add_more_existing_notes" />
                    </div>
                    <form id="add_notes_to_existing_form">
                        <div class="formLabelRow">
                            <input type="text" id="add_existing_note" placeholder="Description" class="episodeFz" />
                            <input type="text" id="add_existing_desc_link" placeholder="Link"   class="edLink" />
                            <input type="number" id="add_existing_priority" class="edPriority" placeholder="Rank" />
                            <input type="button" id="add_existing_button" value="Add" />
                        </div>
                    </form>
                </div>
                <div id="edit_notes" class="hideMe">
                    <form id="edit_notes_form">
                        <div class="formLabelRow" id="edit_label">
                            <div class="labelDivWide">Select an episode:</div>
                            <span id="edit_notes_dropdown"></span>
                            <input type="button" id="episode_select" value="GO!" />
                        </div>
                    </form>
                </div>
                <div id="add_episode" class="hideMe">
                    <form id="add_episode_form">
                        <div class="formLabelRow">
                            <div class="labelDivWide">Episode number:</div>
                            <input type="number" id="episode_number" value="<?=$new_episode?>"/>
                            <span id="actual_episode"></span>
                        </div>
                        <div class="formLabelRow">
                            <div class="labelDivWide">Episode topic:</div>
                            <input type="text" id="episode_topic" />
                        </div>
                        <div class="formLabelRow">
                            <div class="labelDivWide">Download link:</div>
                            <input type="text" id="download_link" />
                        </div>
                        <div class="formLabelRow">
                            <div class="labelDivWide">Publish:</div>
                            <input type="checkbox" id="publish" />
                        </div>
                        <div class="formLabelRow">
                            <input type="button" id="click_to_add_notes" value="Click to add notes" />
                            <input type="button" id="click_to_submit" value="Click to submit" />
                        </div>
                    </form>
                    <div id="add_episode_notes">
                        <div class="formLabelRow">
                            Description:
                            <input type="text" id="description_" />
                            Link:
                            <input type="text" id="descriptionlink" />
                            Priority:
                            <input type="number" id="priority" />
                        </div>
                    </div>
                    <div id="new_notes_container">

                    </div>
                    <div class="formLabelRow">
                        <input type="button" id="click_to_submit_all" value="Click to submit" />
                    </div>
                </div>
                <div id="news" class="hideMe">
                    <form id="news_form">
                        <div class="formLabelRow">
                            Date (YYYY/MM/DD):
                            <input type="text" id="news_date" />
                        </div>
                        <div class="formLabelRow">
                            Headline:
                            <input type="text" id="news_headline" />
                        </div>
                        <div class="formLabelRow">
                            Article:<br>
                            <textarea rows="12" cols="80" id="news_article"></textarea>
                        </div>
                        <div class="formLabelRow">
                            <button type="button" id="news_button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="header_contact">
                <div id="soc_row">
                    <div id="itunes">
                        <a href="https://itunes.apple.com/us/podcast/pie-factory-podcast/id988509945?mt=2&uo=6&at=&ct=" target="itunes_store"></a>
                    </div>
                    <div id="twit">
                        <div id="twit0"><a href="https://twitter.com/PieFactoryPFP" class="twitter-follow-button" data-show-count="false">Follow @PieFactoryPFP</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div><br />
                    </div>
                    <div id="fbok">
                        <div class="fb-like" data-href="https://www.facebook.com/PieFactoryPodcast" data-layout="button" data-action="like" data-show-faces="true"></div>
                    </div>
                </div>
                <div id="eml">
                        <div id="eml0">E-mail: </div><div id="eml1">pie</div><div id="eml2">factory@fab4it.co</div><div id="eml3">m</div><br />
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#episode_number').on('change', function() {
                var epnum = parseInt($('#episode_number').val());
                if (epnum === 16) {
                    $('#actual_episode').html("(actually ep. 15 pt. 2)");
                } else if (epnum > 16) {
                    $('#actual_episode').html("(actually ep. " + (--epnum) + ")");
                }
            });
        });
    </script>