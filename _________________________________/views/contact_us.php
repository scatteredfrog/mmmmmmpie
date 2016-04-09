<div id='form_container'>
    <form ng-hide="messageSent" id='contact_form'>
        <div class='cRow'>
            <div class="contactQ">
                What name do you go by?
            </div>
            <div class='contactA'>
                <input type="text" id="cname" ng-model="cname" />
            </div>
        </div>
        <div class='cRow'>
            <div class="contactQ">
                In case we want to respond, we need your e-mail address.
            </div>
            <div class='contactA'>
                <input type='email' id='cemail' ng-model='cemail' />
            </div>
        </div>
        <div class='cRow'>
            <div class='contactQ'>
                What would you like to tell us? (And please give us at least 25 characters!) 
                <span class="charCount" ng-class="{'redChars': messageChars < 25}">[{{messageChars}} characters]</span><br />
                <a id='csubmit' ng-click="submitContact();">(Click here to submit)</a>
            </div>
            <div class='contactA'>
                <textarea ng-keypress="countCharacters();" ng-keydown="countCharacters();" ng-keyup="countCharacters();" id='ctellus' name='ctellus' ng-model='ctellus'></textarea>
            </div>
        </div>
    </form>
    <div class="cRow" ng-show="messageSent">
        Thanks for your feedback!
    </div>
</div>  