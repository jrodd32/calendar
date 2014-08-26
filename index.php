<!doctype html>
<html>
<head>
<style type='text/css'>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}
		
	#loading {
		position: absolute;
		top: 5px;
		right: 5px;
		}
	
	/**
	 *	Changing the width on this will auto scale the calendar
	 */
	#calendar {
		width: 400px;
		margin: 0 auto;
		margin-top:25px;
	}

</style>
</head>
<body>
	<ul style="list-style-type:none;cursor:pointer;" class="accordion">
		<a href="#" class="check" data-room="NICE">Love Shack Chalet (this is just for testing the click event)</a>
	</ul>
	<!-- Start: Calendar -->
	<div id='calendar'></div> <!-- End Calendar -->
<script type='text/javascript' src='js/jquery-1.8.1.min.js'></script>
<script type='text/javascript' src='js/jquery-ui-1.8.23.custom.min.js'></script>
<script type='text/javascript' src='js/fullcalendar.min.js'></script>

<script type='text/javascript'>
	
	  
	$(document).ready(function() {
		
		/**
		 *	Run ajax call to server for calendar data
		 */
		$('body').on('click', 'a.check', function() { 
		
			// Are there no other calendars that exist in this element? Good.
			if($('.cabin-calendar', this).length == 0)
			{
				// Get current year
				var year = new Date().getFullYear();
				
				// Get cabin type
				var cabinType = $(this).data('room');
				var cabin = {
					'RT': cabinType,
					'pw': '5star',
					'SD': year + '-1-01',
					'ED': year + '-12-31'
				}
				
				// Get the data from the server via AJAX
				$.ajax({
					type    : "POST",
					url     : "inc/get-cabins.php",
					data    : {'cabin' : cabin},
					dataType: 'JSON',
					context: this,
					success : function(data) {
						if(data.hasOwnProperty('HotelReference'))
						{
							// Get the JSON data packet
							var cabins = data;
							
							// Create array to hold start and end date
							var cabins_list_start = [];
							var cabins_list_end = [];
							var cabin_dates = [];
							
							// Iterate through the cabins object to get all start/end dates
							for(var i in cabins.HotelReference.Inventories)
							{

								// Iterate through the correct one
								for(var key in cabins.HotelReference.Inventories.Inventory)
								{
									if(cabins.HotelReference.Inventories.Inventory[key]['@attributes'].Remaining == 0)
									{
										// Get room type 
										cabins_list_start[+key] = cabins.HotelReference.Inventories.Inventory[key]['@attributes'].StartDate;
										cabins_list_end[+key] = cabins.HotelReference.Inventories.Inventory[key]['@attributes'].EndDate;
									}
								}
							}
							
							// Iterate through each of the cabins
							for(var i = 0; i < cabins_list_start.length; i++)
							{
								// Set the start and end dates
								var startDate = cabins_list_start[i];
								var endDate = cabins_list_end[i];
								
								// Create an object to indicate booked for the time slots
								var cabinObj = {
									'title' : "Booked",
									'start' : startDate,
									'end' 	: endDate	
								}
								
								// Put the object into an array
								cabin_dates.push(cabinObj);
							}
							
							$('#calendar').empty().hide().fadeIn(300);
							
							// Build the calendar
							$('#calendar').fullCalendar({
								disableDragging: true,
								eventBackgroundColor: '#e5473e',
								eventBorderColor: '#D3261D',
								editable: true,
								events: cabin_dates
							});						
						}
						else
						{
							
							$('#calendar').empty().hide().fadeIn(300);
							
							// Build the calendar
							$('#calendar').fullCalendar({
								disableDragging: true,
								eventBackgroundColor: '#e5473e',
								eventBorderColor: '#D3261D',
								editable: true,
								events: cabin_dates
							});
						}
					}
				}); 
			}
		});
		
	});

</script>
</body>
</html>