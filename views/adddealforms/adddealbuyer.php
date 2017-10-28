<div id="clientform">
	<h2>Buyer Listing Setup</h2>
	<form class="standard-form" ng-class="{fadeing:true}" name="listform" ng-submit="submitform(listform)" method="POST" novalidate>
		<p>required = *</p>
		<div class="hiddenstuff">
			<input type="hidden" name="test1" ng-init="listobject.typeoflist = 'Buying'" value="buying">
			<input type="hidden" name="test2" ng-init="accntype = 'Buyer'">
			<input type="hidden" name="test3">
		</div>
		<div class="fusion-one-half one_half fusion-column">
			<label for="listname"><?php _e('Listing Title(*)', 'clientexchangeforms'); ?></label>
			<input type="text" autofocus  ng-class="{true: 'errorinput'}[submitted && listform.listname.$invalid]" ng-required="true" name="listname" ng-model="listobject.listname" ng-minlength="3" ng-maxlength="22" placeholder="<?php _e('Listing Title', 'clientexchangeforms'); ?>">
            <p ng-show="listform.listname.$error.minlength" class="help-block">listname is too short Min Caracters 3.</p>
            <p ng-show="listform.listname.$error.maxlength" class="help-block">listname is too long Max 20 caracters.</p>

			<label for="listdesc"><?php _e('Listing Description(*)', 'clientexchangeforms'); ?></label>
			​<textarea ng-class="{true: 'errorinput'}[submitted && listform.listdesc.$invalid]" ng-required="true" id="txtArea" rows="10" cols="70" name="listdesc" ng-model="listobject.listdesc" placeholder="<?php _e('Listing Description', 'clientexchangeforms'); ?>"></textarea>
			<p class="note"><?php _e('Describe your business for sale', 'clientexchangeforms'); ?></p>
			
			<label for="listaddyone"><?php _e('Address', 'clientexchangeforms'); ?></label>
			<input  ng-class="{true: 'errorinput'}[submitted && listform.listaddyone.$invalid]"  type="text" ng-model="listobject.listaddyone" name="listaddyone" placeholder="<?php _e('Address', 'clientexchangeforms'); ?>">


			<label for="city"><?php _e('City(*)', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.city.$invalid]" ng-required="true" type="text" ng-model="listobject.city" name="city" placeholder="<?php _e('City', 'clientexchangeforms'); ?>">



			<label for="province"><?php _e('Province / State', 'clientexchangeforms'); ?></label>
			<input type="text" ng-class="{true: 'errorinput'}[submitted && listform.province.$invalid]" ng-model="listobject.province" name="province" placeholder="<?php _e('Province / State', 'clientexchangeforms'); ?>">

			<label for="pcode"><?php _e('Postal Code / Zip Code', 'clientexchangeforms'); ?></label>
			<input type="text" ng-class="{true: 'errorinput'}[submitted && listform.pcode.$invalid]" ng-model="listobject.pcode" name="pcode" placeholder="<?php _e('Province/State', 'clientexchangeforms'); ?>">

			<label for="country"><?php _e('Country', 'clientexchangeforms'); ?></label>
			<select ng-class="{true: 'errorinput'}[submitted && listform.country.$invalid]" ng-model="listobject.country" name="country">
				<option value="  " selected="">(please select a country)</option>
				<option value="--">none</option>
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

			<label for="fullname"><?php _e('Full Name(*) ', 'clientexchangeforms'); ?></label>
			<input ng-class="{true: 'errorinput'}[submitted && listform.fullname.$invalid]" ng-required="true" type="text" ng-model="listobject.fullname" name="fullname" placeholder="<?php _e('Full Name', 'clientexchangeforms'); ?>">									
			<p class="note"><?php _e('For internal use only', 'clientexchangeforms'); ?></p>

			<label for="mutfund"><?php _e('Mutual Fund Licensed(*)', 'clientexchangeforms'); ?></label>
			<div class="radiowrap" ng-class="{true: 'errorinput'}[submitted && listform.mutfund.$invalid]">
				<input ng-required="true" type="radio" ng-model="listobject.mutfund" name="mutfund" value="yes">Yes<input type="radio" ng-required="true" ng-model="listobject.mutfund" name="mutfund" value="no">No
			</div>

			<label for="liscnlife"><?php _e('Life Insurance Licensed(*)', 'clientexchangeforms'); ?></label>
			<div class="radiowrap" ng-class="{true: 'errorinput'}[submitted && listform.liscnlife.$invalid]">
				<input ng-required="true" type="radio" ng-model="listobject.liscnlife" name="liscnlife" value="yes">Yes<input type="radio" ng-required="true" ng-model="listobject.liscnlife" name="liscnlife" value="no">No
			</div>
		</div>
		<div class="fusion-one-half one_half fusion-column last">

			<label for="othliscn"><?php _e('Other Licenses', 'clientexchangeforms'); ?></label>
			​<textarea id="txtAreaothliscn" rows="10" cols="70" ng-model="listobject.othliscn" name="othliscn" placeholder="<?php _e('Other Licenses', 'clientexchangeforms'); ?>"></textarea>
			<p class="note"><?php _e('Please Explain any other licenses and/or designations', 'clientexchangeforms'); ?></p>

			<label for="fnddate"><?php _e('Founding date(*)', 'clientexchangeforms'); ?></label>
			<input ng-required="true" type="date" ng-model="listobject.fnddate" name="fnddate" id="datepicker" ng-class="{true: 'errorinput'}[submitted && listform.fnddate.$invalid]" placeholder="<?php _e('Founding date', 'clientexchangeforms'); ?>">

			<label for="numbclnts"><?php _e('Number of Clients(*)', 'clientexchangeforms'); ?></label>
			<input ng-required="true" ng-class="{true: 'errorinput'}[submitted && listform.numbclnts.$invalid]" type="number" ng-model="listobject.numbclnts" name="numbclnts" placeholder="<?php _e('Number of Clients', 'clientexchangeforms'); ?>">

			<label for="astundmang"><?php _e('Assets under Management(*)', 'clientexchangeforms'); ?></label>
			<select ng-class="{true: 'errorinput'}[submitted && listform.astundmang.$invalid]" ng-required="true" placeholder="Select a option" ng-model="listobject.astundmang" name="astundmang" id="astundmang">
				<option value="0-500,000">0-500,000</option>
				<option value="500,000-1,000,000">500,000-1,000,000</option>
				<option value="1,000,000-5,000,000">1,000,000-5,000,000</option>
				<option value="5,000,000+">5,000,000 +</option>
			</select>

			<label for="anlcmpnstn"><?php _e('Annual Compensation from Investment Trailers(*)', 'clientexchangeforms'); ?></label>			
			<input ng-required="true" ng-class="{true: 'errorinput'}[submitted && listform.anlcmpnstn.$invalid]" type="number" ng-model="listobject.anlcmpnstn" name="anlcmpnstn" placeholder="<?php _e('Annual Compensation', 'clientexchangeforms'); ?>">

			<label for="akspric"><?php _e('Asking Price(*)', 'clientexchangeforms'); ?></label>			
			<input ng-required="true" ng-class="{true: 'errorinput'}[submitted && listform.akspric.$invalid]" type="number" ng-model="listobject.akspric" name="akspric" placeholder="<?php _e('Asking Price', 'clientexchangeforms'); ?>">						
			
			<label for="slltrms"><?php _e('Acceptance of Seller Terms(*)', 'clientexchangeforms'); ?></label>
			<div class="radiowrap" ng-class="{true: 'errorinput'}[submitted && listform.slltrms.$invalid]">
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