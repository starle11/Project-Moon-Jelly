<!--
Author: Joseph Nolan
Major: IT
Creation Date: 2/28/24
Course: Software Engineering
Professor Name: Prof. Hussain
Assignment: Project
Filename: timer.php
Purpose: So far this is an example file to show the functionality of the timer. Eventually 
it will become a popup
-->
<!DOCTYPE html>
<html lang="en">

<!--Timer-->
<header>
    <h3>Timer</h3>
	<!--Create form-->
    <form onsubmit="startTimer(document.getElementById('duration').value); return false;">
        <label for="duration">Enter How long you would like to study for:</label><br>
        <input type="number" id="duration" name="duration" required><br><br>
        <input type="submit" value="Start Timer">
    </form>
	<!--Display Countdown Timer-->
    <div id="timer"></div>
</header>

<script>
	//Timer functions
	function startTimer(duration) {
        var timerDisplay = document.getElementById('timer');
		
		//Current time
        var startTime = Math.floor(Date.now() / 1000);
		
		//Time to count to
        var endTime = startTime + parseInt(duration) * 60;
		
		//Update timer
        var timerInterval = setInterval(updateTimer, 1000);
        function updateTimer() {
            var currentTime = Math.floor(Date.now() / 1000);
            var remainingTime = endTime - currentTime;
			//Time Done
            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = 'Timer expired!';
			//Countdown
            } else {
                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;
                timerDisplay.textContent = 'Timer: ' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
            }
        }
	}

</script>
</html>
