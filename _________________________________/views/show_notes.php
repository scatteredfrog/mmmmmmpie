<div class="nextPage">
    &nbsp;
    <span ng-show="currentPage > 0" ng-click="decrementPage()">
        <img src="images/arrow_gauche.jpg" />
    </span>
</div>
<div class="paginatedList">
<ul>
    <li ng-repeat="returnedShow in page[currentPage]" ng-click="showNotesPop($index);">
        Episode {{returnedShow.episode_number}}: {{returnedShow.episode_topic}}
    </li>
</ul>
</div>
<div class="prevPage">
    <span ng-show="currentPage < (numberOfPages-1)" ng-click="incrementPage()">
        <img src="images/arrow_droit.jpg" />
    </span>
    &nbsp;
</div>

<div class="showNotes0" ng-show="displayCurrent.episode_number">
    <h3>Episode {{displayCurrent.episode_number}}: {{displayCurrent.episode_topic}}</h3>
    <a href="{{displayCurrent.download_link}}">
        <h4>Download or listen here</h4>
    </a>    
    <div ng-click="showRatings(displayCurrent.episode_number)" ng-show="ratings[displayCurrent.episode_number] && !hideMe" class="showNote howDidTheyRateEm">
        How did Jim'n'Sean rate these games?
    </div>
    <div class="showNote howDidTheyRateEm noPaddingTop" ng-show="ratingsToShow[displayCurrent.episode_number] && hideMe">
        <div ng-repeat="rating in ratings[displayCurrent.episode_number]" class="centerGame showRatings ">
            {{rating.game}}
            <div class="ratingsContainer">
                <div class="jimRating" ng-show="rating.jimRating">
                    <span class="bold">Jim:</span> 
                    <span ng-show="rating.jimRating > 0">{{rating.jimRating}}</span> 
                    <span ng-if="rating.jimRating === 0 || rating.jimRating == ''"> (opted not to rate)</span>
                    <span ng-if="rating.jimRating == 1"> Continue</span>
                    <span ng-if="rating.jimRating > 1"> Continues</span>
                </div>
                <div class="seanRating" ng-show="rating.seanRating">
                    <span class="bold">Sean:</span> 
                    <span ng-show="rating.seanRating > 0">{{rating.seanRating}}</span> 
                    <span ng-if="rating.seanRating === 0 || rating.seanRating == ''"> (opted not to rate)</span>
                    <span ng-if="rating.seanRating == 1"> Continue</span>
                    <span ng-if="rating.seanRating > 1"> Continues</span>
                </div>
            </div>
        </div>
    </div>
    <div ng-repeat="shownote in displayCurrent.notes" class="showNote">
        <a href="{{shownote.description_link}}"><span ng-bind-html="shownote.note"></span></a>
    </div>
        <?php
//            echo 'Episode number: ' . $epnum."---flirzle";
//            foreach($show['notes'] as $key=>$note) {
//                echo "<div class='showNote'>" . anchor_popup($note['description_link'], $note['note']) . '</div>';
//            }
        ?>
    </div>
