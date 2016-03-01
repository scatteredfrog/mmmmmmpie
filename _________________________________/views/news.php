<div class="nextPage">
    &nbsp;
    <span ng-show="currentNewsPage > 0" ng-click="decrementNewsPage()">
        <img src="../images/arrow_gauche.jpg" />
    </span>
</div>
<div class="paginatedList">
<ul>
    <li ng-repeat="returnedNews in pageNews[currentNewsPage]" ng-click="newsPop($index);" class="clickMenuOption">
        <span class="newsDate">{{returnedNews.date}}:</span> <span class="newsHeadline">{{returnedNews.headline}}</span> 
        <a>(click to show/hide story)</a>
        <div ng-show="show_news[$index]" class="newsArticle">{{returnedNews.article}}</div>
    </li>
</ul>
</div>
<div class="prevPage">
    <span ng-show="currentNewsPage < (numberOfNewsPages-1)" ng-click="incrementNewsPage()">
        <img src="../images/arrow_droit.jpg" />
    </span>
    &nbsp;
</div>
