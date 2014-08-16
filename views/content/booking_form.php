<?php 
$h_type = $itiMdl->getItineraryRoots();
	$country_list = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepal",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);
?>
<form id="msform" action = "#" method = "POST">
							<!-- progressbar -->
							<ul id="progressbar">
								<li class="active">Travel Information</li>
								<li>Personal Information</li>
							</ul>
							<!-- fieldsets -->
							<fieldset>
								<h2 class="fs-title">Book Your Trip</h2>
								<h3 class="fs-subtitle">Travel Information</h3>
								<label>Trip Type :</label> 
									<select id = "holidaytype" name = "holiday_type">
										<option>Select Trip type</option>
										<?php foreach($h_type as $type):?>
											<option value = "<?=$type->nav_id?>"><?=$type->nav_title?></option>
										<?php endforeach;?>	
									</select>
								<br>
								<label>Trip :</label><select id = "holidays" name = ""></select><br>
								<input type="text" id = "datepicker1" name="book_depart" placeholder="Start Date" required/>
								<input type="text" id = "datepicker2" name="book_arriv" placeholder="End Date" required/>
								
								<label style = "font-weight:normal">Select number of passengers</label>
								<select id="passengers" class = "form-control" name = "book_nop" required>
								<option>Select number of passengers</option>
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">3</option>
								<option value = "4">4</option>
								<option value = "5">5</option>
								</select><br>
								<!-- <label style = "font-weight:normal">Do you require international flights with your holiday booking</label><br> -->
								<!-- <input style = "width:10px;margin-left:0px" type = "radio" name = "book_req_intl_flights">&nbsp;Yes -->
								<input style = "width:10px;margin-left:0px" type = "hidden" value="no" name = "book_req_intl_flights" >
								<input type="button" name="next" class="next action-button" value="Next"/>
							</fieldset>
							<fieldset>
								<h2 class="fs-title">Book Your Trip</h2>
								<h3 class="fs-subtitle">Personal Information</h3>
								<label class="label" for="fname">First Name</label>
								<input type="text" class="" name="fname" placeholder="Your First and Middle Name" required />

								<label class="label" for="name">Last Name</label>
								<input type="text" class="" name="lname" placeholder="Your Last Name" required/>

								<label class="label" for="email">Email</label>
								<input type="text" class="" name="email" placeholder="Your email address" required/>

								<label class="label" for="phone">Phone</label>
								<input type="text" name="phone" placeholder="Your contact phone no" />

								<label class="label" for="address1">Address 1:</label>
								<input type="text" class="" name="address1" placeholder="Address..." />

								<label class="label" for="address1">Address 2:</label>
								<input type="text" class="" name="address2" placeholder="Address..."/>

								<label class="label" for="city">City:</label>
								<input type="text" class="" name="city" placeholder="City" required/>

								<select class = "form-control" name ="country" required>
								<option value="">Select your Country</option>
								<?php foreach($country_list as $country):?>
									<option value="<?=$country?>"><?=$country?></option>
								<?php endforeach;?>
								</select>
								<label class="label" for="zip">Postal Code:</label>
								<input type="text" class="" name="zip" placeholder="Zip code..." />
								<input type="button" name="previous" class="previous action-button" value="Previous" />
								<input type="submit" name="submit" class="submit action-button" value="Submit" />								
							</fieldset>
						</form>