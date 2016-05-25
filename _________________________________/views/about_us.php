<div class="aboutUsContainer">
    <div ng-class="{yourHosts: aboutHosts=='about'||aboutHosts=='credits', jimHost: aboutHosts=='jim', seanHost: aboutHosts=='sean'}" id="your_hosts">

    </div>
    <div class="aboutYourHosts">
        <div ng-if="aboutHosts==='jim'">
            Jimmy G is a lifelong resident of the SW Chicago suburbs.  He's pretty dang old, and 
            getting older, but still feels like he's 27.<br />&nbsp;<br />At one time or 
            another, he's owned every Atari home game console, except the Jaguar. 
            Currently Jim has an Atari 2600, 5200, 7800, 65XE, Coleco Adam, Wii, Wii U, several 
            Nintendo DS units, and a Sega Master System. Currently he is exploring emulation with 
            the Raspberry Pi.<br />
            &nbsp;<br />
            Jim also enjoys cheesy B films, 
            <span class='italic'>Mystery Science Theater 3000</span>, Monty Python, bicycle 
            riding (his top distance is 100 miles in one ride), hiking, collecting road maps, 
            and talking about himself in the third person.
        </div>
        <div ng-if="aboutHosts==='sean'">
            Sean is a lifelong Libra and a web developer. 
            (And that he also developed this site proves that programmers 
            just can't design.)<br />
            &nbsp;<br />His first console was an Atari 
            2600, a Christmas present in 1982; he still plays 2600 games to this day. 
            At various times Sean has owned an Atari 5200, Intellivision, Vectrex, Commodore 
            64, and various Amigas. Now he owns an Atari 
            600XL, Atari 7800, and a Retro Duo Portable, on which he plays NES, SNES, and 
            Sega Genesis games. He holds {{tg_sean}} world records on Twin Galaxies.<br />
            &nbsp;<br />
            Sean lives in Chicago and is an avid music fan; 
            ask him about the time he 
            shook hands with Brian Wilson or testified in a Mike Love lawsuit.
        </div>
        <div ng-if="aboutHosts==='about'">
            Jim and Sean, shown here discussing which games they'll <span class='strike'>look up on 
            Wikipedia</span> research diligently so they can have an intelligent discussion on the 
            next episode, on a biweekly basis try to fulfill their mission to make 
            <span class='italic'>Tinkle Pit</span> a 
            household name.<br />
            &nbsp;<br />
            In each episode, Sean and Jim discuss two (2) classic 
            arcade games and reveal a common theme. Because they're longtime classic console 
            gamers, the hosts also give a home gamer's perspective on the games they discuss. (And 
            because both are from the Chicago area, there's a bit of provinciality as well.)<br />
            &nbsp;<br />
            Oh...did we mention...<span class='italic'>Tinkle Pit</span>?
        </div>
        
        <div ng-if='aboutHosts==="credits"'>
            <div class="credits" id="show_cred">
            <div class="marquee">
                <span class="credHead">Hosts</span>
                <span class="cred">Sean Courtney</span>
                <span class="cred">Jim Goebel</span>
                <span class="credSpace"></span>
                <span class="credHead">Post Production</span>
                <span class="cred">Sean Courtney</span>
                <span class="cred">Jim Goebel</span>
                <span class="cred">Hyde St. Pi&egrave;rre</span>
                <span class="credSpace"></span>
                <span class="credHead">Booth Announcer</span>
                <span class="cred">Lisa Courtney</span>
                <span class="credSpace"></span>
                <span class="credHead">Music</span>
                <span class="cred">"The Happy L"</span>
                <span class="cred">"The Happy CTA Holiday Train"</span>
                <span class="cred">composed by Sean Courtney</span>
                <span class="credSpace"></span>
                <span class="cred">"Love Theme From <span class="italic">Addenda and Errata</span>"</span>
                <span class="cred">composed by Jim Goebel</span>
                <span class="credSpace"></span>
                <span class="cred">performed by Scattered Frog</span>
                <span class="credSpace"></span>
                <span class="credHead">Many Thanks to Our Donors</span>
                <span class='cred' ng-repeat='patron in patrons'>{{patron}}</span>
            </div>
            </div>
        </div>
        <a ng-click="changeHost('about')">About The Hosts</a> &#183;
        <a ng-click="changeHost('jim')">About Jimmy G</a> &#183; 
        <a ng-click="changeHost('sean')">About Sean</a> &#183;
        <a ng-click="changeHost('credits')">Show Credits</a>
    </div>
</div>
