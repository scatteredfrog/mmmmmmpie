<div class="aboutUsContainer">
    <div ng-class="{yourHosts: aboutHosts==about, jimHost: aboutHosts==aboutJim, seanHost: aboutHosts==aboutSean}" id="your_hosts">

    </div>
    <div class="aboutYourHosts">
        <span ng-bind-html="aboutHosts"></span><br />&nbsp;<br />
        <a ng-click="changeHost('hosts')">About The Hosts</a> &#183;
        <a ng-click="changeHost('jim')">About Jimmy G</a> &#183; 
        <a ng-click="changeHost('sean')">About Sean</a>
    </div>
</div>