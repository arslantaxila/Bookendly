<!DOCTYPE html>
<html>

<head>
	<title>Book a Mentorship Session</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
	<script>
		$(document).ready(function() {
			var events = [];
			getOnlineEvents();

			function getOnlineEvents() {
				$.get("https://private-37dacc-cfcalendar.apiary-mock.com/mentors/1/agenda", function(data, status) {
					events = [];


					data.calendar.map((item) => {
						const dateObj = new Date(item.date_time);

						let year = dateObj.getFullYear();

						let month = dateObj.getMonth() + 1;
						month = ('0' + month).slice(-2);
						// To make sure the month always has 2-character-formate. For example, 1 => 01, 2 => 02

						let date = dateObj.getDate();
						date = ('0' + date).slice(-2);
						// To make sure the date always has 2-character-formate

						let startHour = dateObj.getHours();
						startHour = ('0' + startHour).slice(-2);
						let endHour = dateObj.getHours() + 1;
						endHour = ('0' + endHour).slice(-2);
						// To make sure the hour always has 2-character-formate

						let minute = dateObj.getMinutes();
						minute = ('0' + minute).slice(-2);
						// To make sure the minute always has 2-character-formate

						let second = dateObj.getSeconds();
						second = ('0' + second).slice(-2);
						// To make sure the second always has 2-character-formate

						const startTime = `${year}-${month}-${date} ${startHour}:${minute}:${second}`;
						const endTime = `${year}-${month}-${date} ${endHour}:${minute}:${second}`;


						events.push({
							"id": 0,
							"title": "API Events",
							"start": startTime,
							"end": endTime
						});

					});

				}).then(getLocalEvents);
			}


			function getLocalEvents() {
				$.get("<?php echo base_url(); ?>load", function(data, status) {

					if (data == '-1')
						return;
					events = events.concat(JSON.parse(data));

				}).then(calenderInitilize);
			}

			function calenderInitilize() {
				var calendar = $('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'listMonth,agendaWeek'
					},
					defaultView: 'agendaWeek',
					allDaySlot: false,
					slotDuration: '01:00',
					events: events,
					selectable: true,
					selectHelper: true,
					select: function(start, end) {
						var reason = prompt("Please enter the reason for the call");
						if (reason) {
							var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
							var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
							$.ajax({
								url: "<?php echo base_url(); ?>insert",
								type: "POST",
								data: {
									reason: reason,
									start: start,
									end: end
								},
								success: function() {
									//to add the latest inserted event in view
									var newEvent = [];
									newEvent.push({
										"id": 0,
										"title": reason,
										"start": start,
										"end": end
									});

									calendar.fullCalendar('addEventSource', newEvent);
									calendar.fullCalendar('refetchEvents');

									$(".alert").addClass("alert-success").text("Successfully Booked!");
									setTimeout(function() {
										$(".alert").removeClass("alert-success").text("");
									}, 3000);

									//to refresh
									$('.fc-listMonth-button').click();
									$('.fc-agendaWeek-button').click();


								}
							})
						}
					},
					eventClick: function(event) {
						$(".alert").addClass("alert-danger").text("Already Booked!");
						setTimeout(function() {
							$(".alert").removeClass("alert-danger").text("");
						}, 3000);
					}
				});
			}
		});
		$(document).on({
			ajaxStart: function() {
				$("body").addClass("loading");
			},
			ajaxStop: function() {
				$("body").removeClass("loading");
			}
		});
	</script>
</head>

<body>
	<br />
	<h2 align="center"><a href="#">Book a Mentorship Session</a></h2>
	<br />
	<div class="row">

		<div class="col-md-10 offset-md-1">
			<div class="alert text-center" role="alert">

			</div>
		</div>

	</div>
	<div class="container">
		<div id="calendar"></div>
	</div>
	<div class="overlay"></div>
</body>

</html>
