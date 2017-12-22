<?php 
include("includes/header.html");
?>
<div class="pagespace">
	<div class="border">
		<div class="errormsg">
			<p id="errormsg"></p>
		</div>

		<div class="ttl-bar">
			<h1 class="ttl1">Get the #1 song on the Billboard Hot 100 from any given date.</h1>
			<p class="ttl2">Try today's date 4 years ago, Christmas in the 80's, or your birthday.</p> 
			<p>The charts go back as far as 1958-08-09</p>
		</div>	

		<form id="birthday-form" style="text-align: center;">
			<input type="text" class="input year" placeholder="YYYY"/>
			<input type="text" class="input month" placeholder="MM"/>
			<input type="text" class="input day" placeholder="DD"/>
			<button id="submit"><i class="fa fa-arrow-right"></i></button>
		</form>

		<div class="results">
			<h3>The #1 song on the Billboard Hot 100 was</h3>
			<h3 class="title"><span id="songTitle"></span> by <span id="artist"></span></h3>
			<div id="spotify"></div>
		</div>	
	</div>
</div>
	
<h2 id="testmsg"></h2>

<script type="text/javascript">
$(document).ready(function() {
$(".errormsg").hide();
$(".results").hide();
	
$('#submit').click(function(e){
	e.preventDefault();

	var year = $(".year").val();
    var month = $(".month").val();
    var day = $(".day").val();
	
	var yearNum = parseInt(year);
	var monthNum = parseInt(month);
	var dayNum = parseInt(day);
	
	if (Number.isInteger(yearNum) && yearNum >= 1958 && yearNum <= 2017 && Number.isInteger(monthNum) && monthNum >= 1 && monthNum <= 12 && Number.isInteger(dayNum) && dayNum >= 1 && dayNum <= 31) {
		console.log('Form Validation passed');
		$(".errormsg").hide();
		if (monthNum < 10) {
			monthNum = "0" + monthNum;
		}
		if (dayNum < 10) {
			dayNum = "0" + dayNum;
		}
		$.ajax({
    		type: "POST",
        	url: "formProcess.php",
        	dataType: "json",
        	data: {year:yearNum, month:monthNum, day:dayNum},
        	success : function(data){
				if (data.code == "200"){
					var array = data;
					$("#artist").empty().append(data.msg[0]);
					$("#songTitle").empty().append(data.msg[1]);
					console.log(data.msg[0], data.msg[1], data.msg[2]);
					$(".results").slideDown();
					if (data.msg[2]) {
						$("#spotify").empty().append('<iframe src="https://open.spotify.com/embed?uri=spotify:track:' + data.msg[2] + '" frameborder="0" allowtransparency="true"></iframe>');
					} else {
						$("#spotify").empty().append('<h1>This song could not be found on Spotify</h1><a href="http://www.google.com/search?q=' + data.msg[1] + ' by ' + data.msg[0] + '" target="_blank"><h1>Search this song on Google</h1></a>');
					}
            	} else {
					$("#testmsg").empty().append(data.msg);
            	}
        	},
			error : function(errormsg) {
				console.log(errormsg);
	   		}   
		})
	} else {
		console.log('Form Validation Failed');
		$(".errormsg").slideDown()
		$("#errormsg").empty().append("Please enter a valid date");
	}
});
}); 
</script>

</body>
</html>
