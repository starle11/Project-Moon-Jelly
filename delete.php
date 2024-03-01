<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
  <?php
   /*
   Group Name:    Moon Jelly
   Name(s):       Joseph Nolan/Julia Craft/Katherine Ringeisen/Raymond Mateo
   Major:         Software Development/CSC IT
   Creation Date: March 1, 2023
   Due Date:      March. 4, 2023
   Course:        CSC 355-810 - Fall 2023
   Professor:     Dr. Tauqeer Hussain
   SE Phase II:   Designing Prototype
   File Name:     delete.php
   Purpose:       Delete account
   Resources:     - 
   */

   session_start();
   //function to logout
   function logout() {
      session_unset();
      session_destroy();
      header("Location: homepage.php?logout=true");
      exit();
      }
  ?>
    <script>
        function deleteUserAccount() {
            // You would typically send an AJAX request to your server here to delete the user account
            // Example using fetch API:
            fetch('delete-account.php', {
                method: 'POST',
                credentials: 'include', // include cookies in the request
            })
            .then(response => {
                if (response.ok) {
                    alert('Account deleted successfully!');
		    <?php
		    logout();
		    ?>
                } else {
                    alert('Error deleting account! Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again later.');
            });
        }

        // Call the deleteUserAccount function when the page loads (you may not need this if you're calling it from another function)
        window.onload = function() {
            deleteUserAccount();
        };
    </script>
</body>
</html>
