<?php defined('ABSPATH') OR exit; ?> 
<div id="clientform">
	<h2>Consultant Listing Setup</h2>
	<form  ng-class="{fadeing:true}" class="standard-form" name="listform" ng-submit="submitform(listform)" method="POST" novalidate>
		<p>required = *</p>
		<div class="hiddenstuff">
			<input type="hidden" name="test1" ng-init="listobject.typeoflist = 'Advisors/Consultants'" value="Selling">
			<input type="hidden" name="test2" ng-init="accntype = 'Advisors / Consultants'">
			<input type="hidden" name="test3" ng-init="plugurl = '<?php echo plugins_url(); ?>'">
			<input type="hidden" name="test3" ng-model="listobject.logo">
		</div>
		<div class="fusion-one-half one_half fusion-column">

			<label for="usertitle"><?php _e('Title(*)', 'clientexchangeforms'); ?></label>
			<select autofocus ng-class="{true: 'errorinput'}[submitted && listform.usertitle.$invalid]" ng-required="true" placeholder="Select a option" ng-model="listobject.usertitle" name="usertitle" id="usertitle">
				<option value="Mr">Mr</option>
				<option value="Ms">Ms</option>
				<option value="Mrs">Mrs</option>
				<option value="Miss">Miss</option>
			</select>

			<label for="fname"><?php _e('First Name(*)', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.fname.$invalid]" ng-required="true"ng-required="true" type="text" ng-model="listobject.fname" name="fname" placeholder="<?php _e('First Name(*)', 'clientexchangeforms'); ?>">


			<label for="lname"><?php _e('Last Name(*)', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.lname.$invalid]" ng-required="true" type="text" ng-model="listobject.lname" name="lname" placeholder="<?php _e('Last Name(*)', 'clientexchangeforms'); ?>">


			<label for="cmpname"><?php _e('Company Name(*)', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.cmpname.$invalid]" ng-required="true" type="text" ng-model="listobject.cmpname" name="cmpname" placeholder="<?php _e('Company Name(*)', 'clientexchangeforms'); ?>">

			<label for="email"><?php _e(' Email(*)', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.email.$invalid]" ng-required="true" type="email" ng-model="listobject.email" name="email" placeholder="<?php _e('Email(*)', 'clientexchangeforms'); ?>">
            <p ng-show="listform.email.$error.email" class="help-block">Email not valid.</p>

			<label for="listaddyone"><?php _e('Work Address', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.listaddyone.$invalid]"  type="text" ng-model="listobject.listaddyone" name="listaddyone" placeholder="<?php _e('Work Address', 'clientexchangeforms'); ?>">



			<label for="city"><?php _e('City(*)', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.city.$invalid]" ng-required="true" type="text" ng-model="listobject.city" name="city" placeholder="<?php _e('City', 'clientexchangeforms'); ?>">



			<label for="province"><?php _e('Province / State(*)', 'clientexchangeforms'); ?></label>
			<input type="text" ng-class="{true: 'errorinput'}[submitted && listform.province.$invalid]" ng-required="true"  ng-model="listobject.province" name="province" placeholder="<?php _e('Province / State', 'clientexchangeforms'); ?>">

			<label for="pcode"><?php _e('Postal Code / Zip Code(*)', 'clientexchangeforms'); ?></label>
			<input type="text" ng-class="{true: 'errorinput'}[submitted && listform.pcode.$invalid]" ng-required="true"  ng-model="listobject.pcode" name="pcode" placeholder="<?php _e('Province/State', 'clientexchangeforms'); ?>">

			<label for="country"><?php _e('Country(*)', 'clientexchangeforms'); ?></label>
			<select ng-class="{true: 'errorinput'}[submitted && listform.country.$invalid]" ng-required="true" ng-model="listobject.country" name="country">
				<option value="--">None</option>
				<option value="AF">Afghanistan </option>
				<option value="AL">Albania </option>
				<option value="DZ">Algeria </option>
				<option value="AS">American Samoa</option>
				<option value="AD">Andorra </option>
				<option value="AO">Angola</option>
				<option value="AI">Anguilla</option>
				<option value="AQ">Antarctica</option>
				<option value="AG">Antigua and Barbuda </option>
				<option value="AR">Argentina </option>
				<option value="AM">Armenia </option>
				<option value="AW">Aruba </option>
				<option value="AU">Australia </option>
				<option value="AT">Austria </option>
				<option value="AZ">Azerbaijan</option>
				<option value="BS">Bahamas </option>
				<option value="BH">Bahrain </option>
				<option value="BD">Bangladesh</option>
				<option value="BB">Barbados</option>
				<option value="BY">Belarus </option>
				<option value="BE">Belgium </option>
				<option value="BZ">Belize</option>
				<option value="BJ">Benin </option>
				<option value="BM">Bermuda </option>
				<option value="BT">Bhutan</option>
				<option value="BO">Bolivia </option>
				<option value="BA">Bosnia and Herzegowina</option>
				<option value="BW">Botswana</option>
				<option value="BV">Bouvet Island </option>
				<option value="BR">Brazil</option>
				<option value="IO">British Indian Ocean Territory</option>
				<option value="BN">Brunei Darussalam </option>
				<option value="BG">Bulgaria</option>
				<option value="BF">Burkina Faso</option>
				<option value="BI">Burundi </option>
				<option value="KH">Cambodia</option>
				<option value="CM">Cameroon</option>
				<option value="CA">Canada</option>
				<option value="CV">Cape Verde</option>
				<option value="KY">Cayman Islands</option>
				<option value="CF">Central African Republic</option>
				<option value="TD">Chad</option>
				<option value="CL">Chile </option>
				<option value="CN">China </option>
				<option value="CX">Christmas Island</option>
				<option value="CC">Cocos (Keeling) Islands </option>
				<option value="CO">Colombia</option>
				<option value="KM">Comoros </option>
				<option value="CG">Congo </option>
				<option value="CD">Congo, the Democratic Republic of the </option>
				<option value="CK">Cook Islands</option>
				<option value="CR">Costa Rica</option>
				<option value="CI">Cote d'Ivoire </option>
				<option value="HR">Croatia (Hrvatska)</option>
				<option value="CU">Cuba</option>
				<option value="CY">Cyprus</option>
				<option value="CZ">Czech Republic</option>
				<option value="DK">Denmark </option>
				<option value="DJ">Djibouti</option>
				<option value="DM">Dominica</option>
				<option value="DO">Dominican Republic</option>
				<option value="TP">East Timor</option>
				<option value="EC">Ecuador </option>
				<option value="EG">Egypt </option>
				<option value="SV">El Salvador </option>
				<option value="GQ">Equatorial Guinea </option>
				<option value="ER">Eritrea </option>
				<option value="EE">Estonia </option>
				<option value="ET">Ethiopia</option>
				<option value="FK">Falkland Islands (Malvinas) </option>
				<option value="FO">Faroe Islands </option>
				<option value="FJ">Fiji</option>
				<option value="FI">Finland </option>
				<option value="FR">France</option>
				<option value="FX">France, Metropolitan</option>
				<option value="GF">French Guiana </option>
				<option value="PF">French Polynesia</option>
				<option value="TF">French Southern Territories </option>
				<option value="GA">Gabon </option>
				<option value="GM">Gambia</option>
				<option value="GE">Georgia </option>
				<option value="DE">Germany </option>
				<option value="GH">Ghana </option>
				<option value="GI">Gibraltar </option>
				<option value="GR">Greece</option>
				<option value="GL">Greenland </option>
				<option value="GD">Grenada </option>
				<option value="GP">Guadeloupe</option>
				<option value="GU">Guam</option>
				<option value="GT">Guatemala </option>
				<option value="GN">Guinea</option>
				<option value="GW">Guinea-Bissau </option>
				<option value="GY">Guyana</option>
				<option value="HT">Haiti </option>
				<option value="HM">Heard and Mc Donald Islands </option>
				<option value="VA">Holy See (Vatican City State) </option>
				<option value="HN">Honduras</option>
				<option value="HK">Hong Kong </option>
				<option value="HU">Hungary </option>
				<option value="IS">Iceland </option>
				<option value="IN">India </option>
				<option value="ID">Indonesia </option>
				<option value="IR">Iran (Islamic Republic of)</option>
				<option value="IQ">Iraq</option>
				<option value="IE">Ireland </option>
				<option value="IL">Israel</option>
				<option value="IT">Italy </option>
				<option value="JM">Jamaica </option>
				<option value="JP">Japan </option>
				<option value="JO">Jordan</option>
				<option value="KZ">Kazakhstan</option>
				<option value="KE">Kenya </option>
				<option value="KI">Kiribati</option>
				<option value="KP">Korea, Democratic People's Republic of</option>
				<option value="KR">Korea, Republic of</option>
				<option value="KW">Kuwait</option>
				<option value="KG">Kyrgyzstan</option>
				<option value="LA">Lao People's Democratic Republic</option>
				<option value="LV">Latvia</option>
				<option value="LB">Lebanon </option>
				<option value="LS">Lesotho </option>
				<option value="LR">Liberia </option>
				<option value="LY">Libyan Arab Jamahiriya</option>
				<option value="LI">Liechtenstein </option>
				<option value="LT">Lithuania </option>
				<option value="LU">Luxembourg</option>
				<option value="MO">Macau </option>
				<option value="MK">Macedonia, The Former Yugoslav Republic of</option>
				<option value="MG">Madagascar</option>
				<option value="MW">Malawi</option>
				<option value="MY">Malaysia</option>
				<option value="MV">Maldives</option>
				<option value="ML">Mali</option>
				<option value="MT">Malta </option>
				<option value="MH">Marshall Islands</option>
				<option value="MQ">Martinique</option>
				<option value="MR">Mauritania</option>
				<option value="MU">Mauritius </option>
				<option value="YT">Mayotte </option>
				<option value="MX">Mexico</option>
				<option value="FM">Micronesia, Federated States of </option>
				<option value="MD">Moldova, Republic of</option>
				<option value="MC">Monaco</option>
				<option value="MN">Mongolia</option>
				<option value="MS">Montserrat</option>
				<option value="MA">Morocco </option>
				<option value="MZ">Mozambique</option>
				<option value="MM">Myanmar </option>
				<option value="NA">Namibia </option>
				<option value="NR">Nauru </option>
				<option value="NP">Nepal </option>
				<option value="NL">Netherlands </option>
				<option value="AN">Netherlands Antilles</option>
				<option value="NC">New Caledonia </option>
				<option value="NZ">New Zealand </option>
				<option value="NI">Nicaragua </option>
				<option value="NE">Niger </option>
				<option value="NG">Nigeria </option>
				<option value="NU">Niue</option>
				<option value="NF">Norfolk Island</option>
				<option value="MP">Northern Mariana Islands</option>
				<option value="NO">Norway</option>
				<option value="OM">Oman</option>
				<option value="PK">Pakistan</option>
				<option value="PW">Palau </option>
				<option value="PA">Panama</option>
				<option value="PG">Papua New Guinea</option>
				<option value="PY">Paraguay</option>
				<option value="PE">Peru</option>
				<option value="PH">Philippines </option>
				<option value="PN">Pitcairn</option>
				<option value="PL">Poland</option>
				<option value="PT">Portugal</option>
				<option value="PR">Puerto Rico </option>
				<option value="QA">Qatar </option>
				<option value="RE">Reunion </option>
				<option value="RO">Romania </option>
				<option value="RU">Russian Federation</option>
				<option value="RW">Rwanda</option>
				<option value="KN">Saint Kitts and Nevis </option>
				<option value="LC">Saint LUCIA </option>
				<option value="VC">Saint Vincent and the Grenadines</option>
				<option value="WS">Samoa </option>
				<option value="SM">San Marino</option>
				<option value="ST">Sao Tome and Principe </option>
				<option value="SA">Saudi Arabia</option>
				<option value="SN">Senegal </option>
				<option value="SC">Seychelles</option>
				<option value="SL">Sierra Leone</option>
				<option value="SG">Singapore </option>
				<option value="SK">Slovakia (Slovak Republic)</option>
				<option value="SI">Slovenia</option>
				<option value="SB">Solomon Islands </option>
				<option value="SO">Somalia </option>
				<option value="ZA">South Africa</option>
				<option value="GS">South Georgia and the South Sandwich Islands</option>
				<option value="ES">Spain </option>
				<option value="LK">Sri Lanka </option>
				<option value="SH">St. Helena</option>
				<option value="PM">St. Pierre and Miquelon </option>
				<option value="SD">Sudan </option>
				<option value="SR">Suriname</option>
				<option value="SJ">Svalbard and Jan Mayen Islands</option>
				<option value="SZ">Swaziland </option>
				<option value="SE">Sweden</option>
				<option value="CH">Switzerland </option>
				<option value="SY">Syrian Arab Republic</option>
				<option value="TW">Taiwan, Province of China </option>
				<option value="TJ">Tajikistan</option>
				<option value="TZ">Tanzania, United Republic of</option>
				<option value="TH">Thailand</option>
				<option value="TG">Togo</option>
				<option value="TK">Tokelau </option>
				<option value="TO">Tonga </option>
				<option value="TT">Trinidad and Tobago </option>
				<option value="TN">Tunisia </option>
				<option value="TR">Turkey</option>
				<option value="TM">Turkmenistan</option>
				<option value="TC">Turks and Caicos Islands</option>
				<option value="TV">Tuvalu</option>
				<option value="UG">Uganda</option>
				<option value="UA">Ukraine </option>
				<option value="AE">United Arab Emirates</option>
				<option value="GB">United Kingdom</option>
				<option value="US">United States </option>
				<option value="UM">United States Minor Outlying Islands</option>
				<option value="UY">Uruguay </option>
				<option value="UZ">Uzbekistan</option>
				<option value="VU">Vanuatu </option>
				<option value="VE">Venezuela </option>
				<option value="VN">Viet Nam</option>
				<option value="VG">Virgin Islands (British)</option>
				<option value="VI">Virgin Islands (U.S.) </option>
				<option value="WF">Wallis and Futuna Islands </option>
				<option value="EH">Western Sahara</option>
				<option value="YE">Yemen </option>
				<option value="YU">Yugoslavia</option>
				<option value="ZM">Zambia</option>
				<option value="ZW">Zimbabwe</option>
			</select>


			<label for="phone"><?php _e('Phone Number(*)', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.phone.$invalid]" ng-required="true" type="text" ng-model="listobject.phone" name="phone" placeholder="<?php _e('Phone Number', 'clientexchangeforms'); ?>">


			<label for="cellphn"><?php _e('Cell Phone', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.cellphn.$invalid]" type="text" ng-model="listobject.cellphn" name="cellphn" placeholder="<?php _e('Cell Phone', 'clientexchangeforms'); ?>">

			<label for="website"><?php _e('Website(*)', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.website.$invalid]" ng-required="true" type="url" ng-model="listobject.website" name="website" placeholder="<?php _e('Website(*)', 'clientexchangeforms'); ?>">
			<p ng-show="listform.website.$error.url" class="help-block">Not a valid url...</p>


			<label for="linkedin"><?php _e('Linkedin', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.linkedin.$invalid]" type="url" ng-model="listobject.linkedin" name="linkedin" placeholder="<?php _e('Linkedin', 'clientexchangeforms'); ?>">
			<p ng-show="listform.linkedin.$error.url" class="help-block">Not a valid url...</p>
			
			<label for="facebook"><?php _e('facebook', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.facebook.$invalid]" type="text" ng-model="listobject.facebook" name="facebook" placeholder="<?php _e('Facebook', 'clientexchangeforms'); ?>">
			<p ng-show="listform.facebook.$error.url" class="help-block">Not a valid url...</p>

			<label for="twitter"><?php _e('Twitter', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.twitter.$invalid]" type="text" ng-model="listobject.twitter" name="twitter" placeholder="<?php _e('Twitter', 'clientexchangeforms'); ?>">
			<p ng-show="listform.twitter.$error.url" class="help-block">Not a valid url...</p>
			
			<label for="blog"><?php _e('Blog', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.blog.$invalid]" type="text" ng-model="listobject.blog" name="blog" placeholder="<?php _e('Blog', 'clientexchangeforms'); ?>">
			<p ng-show="listform.blog.$error.url" class="help-block">Not a valid url...</p>
          
		</div>
		<div class="fusion-one-half one_half fusion-column last">

			<label for="industrycategory"><?php _e('Industry Category(*)', 'clientexchangeforms'); ?></label>
			<select ng-class="{true: 'errorinput'}[submitted && listform.industrycategory.$invalid]" ng-required="true" placeholder="Select a option" ng-model="listobject.industrycategory" name="industrycategory" id="industrycategory">
					<option value="0">NEED THIS LIST...</option>
			</select>

			<label for="listname"><?php _e('Listing Title(*)', 'clientexchangeforms'); ?></label>
			<input type="text"  ng-class="{true: 'errorinput'}[submitted && listform.listname.$invalid]" ng-required="true" name="listname" ng-model="listobject.listname" ng-minlength="3" ng-maxlength="22" placeholder="<?php _e('Listing Title', 'clientexchangeforms'); ?>">
            <p ng-show="listform.listname.$error.minlength" class="help-block">listname is too short Min Caracters 3.</p>
            <p ng-show="listform.listname.$error.maxlength" class="help-block">listname is too long Max 20 caracters.</p>

			<label for="listdesc"><?php _e('Business Description(*)', 'clientexchangeforms'); ?></label>
			​<textarea ng-class="{true: 'errorinput'}[submitted && listform.listdesc.$invalid]" ng-required="true" id="txtArea" rows="10" cols="70" name="listdesc" ng-model="listobject.listdesc" placeholder="<?php _e('Buisness Description', 'clientexchangeforms'); ?>"></textarea>
			<p class="note"><?php _e('Describe your business for sale', 'clientexchangeforms'); ?></p>

			<label for="areaexpertise"><?php _e('Industry Category(*)', 'clientexchangeforms'); ?></label>
			<select ng-class="{true: 'errorinput'}[submitted && listform.areaexpertise.$invalid]" ng-required="true" placeholder="Select a option" ng-model="listobject.areaexpertise" name="areaexpertise" id="areaexpertise">
					<option value="Buisness Valuators">Buisness Valuators</option>
					<option value="Lawyers">Lawyers</option>
					<option value="Accountants">Accountants</option>
					<option value="Financiers">Financiers</option>
					<option value="Other Providerers">Other Providerers</option>
			</select>
		<div id="logoupload">
			<h2>Logo upload</h2>
			<img ng-show="showlogo" src="{{listobject.logo}}" alt="{{filetitle}}">
			<p ng-show="showurl">{{listobject.logo}}</p>
			<input type="file" ng-file-select="onFileSelect($files)" />
		</div>
			<label for="vidurl"><?php _e('Video url', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.vidurl.$invalid]" type="url" ng-model="listobject.vidurl" name="vidurl" placeholder="<?php _e('Video Url', 'clientexchangeforms'); ?>">
            <p ng-show="listform.vidurl.$error.url" class="help-block">Not a valid url...</p>

			<label for="metakey"><?php _e('Meta Keywords', 'clientexchangeforms'); ?></label>
			<input 	 ng-class="{true: 'errorinput'}[submitted && listform.metakey.$invalid]" type="text" ng-model="listobject.metakey" name="metakey" placeholder="<?php _e('Meta Keywords', 'clientexchangeforms'); ?>">
            <p class="note">Comma seperated list please.</p>

			<label for="metatag"><?php _e('Meta Tags', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.metatag.$invalid]" type="text" ng-model="listobject.metatag" name="metatag" placeholder="<?php _e('Meta Tags', 'clientexchangeforms'); ?>">
            <p class="note">Comma seperated list please.</p>

			<label for="slltrms"><?php _e('Acceptance of Seller Terms(*)', 'clientexchangeforms'); ?></label>
			<div  class="radiowrap" ng-class="{true: 'errorinput'}[submitted && listform.slltrms.$invalid]">
				<input type="checkbox" ng-model="listobject.slltrms"  ng-required="true" name="slltrms" value="accepeted">I Accept
			</div>
				<p>	By checking off this box.
					Member accepts the terms and conditions of the CLIENT EXCHANGE SELLER AGREEMENT and acknowledges that the Parties 
					have caused this Agreement to be executed, as of today’s date (the “Commencement Date”). 
					This agreement is not binding until a duly executed copy is received by Client Exchange.</p>
					<p>To view this agreement, <a href="/wp-content/uploads/2014/07/CE+Seller+Membership+Agmt.pdf">please click here.</a></p>


		</div>
		<input class="button" type="submit">
	</form>
</div>