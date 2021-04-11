<?php
    include "test_connect.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <style>
            .normal
            {
                filter: invert(0%);
            }
            .dark
            {
                filter: invert(100%);
                background-color: black;
            }
        </style>
    </head>
    <body class="normal">

        <nav class="navbar navbar-expand-md" style="background-color: black;">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Enter Symptoms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><button id="darkmodebutton" class="nav-link">Dark Mode</button></li>
                <li class="nav-item"><a href="#" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Register</a></li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="jumbotron jumbotron-fluid" style="background-color:orange;">
                <h1 class="text-center">Enter symptoms...</h1><br>
                <div class="container">
                        <div class="active-cyan-4 mb-4">
                                <input id="searchbox" class="form-control" type="text" placeholder="Search" aria-label="Search">
                        </div>
                </div>
                <div id="suggestions" class="jumbotron jumbotron-fluid text-center" style="background-color:orange;">
                    <!--SEARCH SUGGESTIONS-->
                </div>
            </div>

            <div class="jumbotron jumbotron-fluid bg-black" style="background-color: black;">
                <div class="container bg-black">
                    <p class="text-muted">About Us</p>
                    <p class="text-muted">Contact Us</p>
                </div>
            </div>
        </div>

        <script>
            var darkmode_button = document.getElementById("darkmodebutton");
            darkmode_button.addEventListener("click",function_dark_mode,false);

            function function_dark_mode()
            {
                if (darkmode_button.innerHTML == "Dark Mode")
                {
                    document.body.className = "dark";
                    darkmode_button.innerHTML = "Light Mode";
                }
                else
                {
                    document.body.className = "normal";
                    darkmode_button.innerHTML = "Dark Mode";
                }
            }

            $(document).ready(function(){
                $("#searchbox").on("keyup", function(){
                    $text = $("#searchbox").val();
                    if($text.length)
                    {
                        $.get("test_search.php", {
                            text: $text
                        }, function(data, status) {
                            $("#suggestions").html(data);
                        });
                    }
                    else{
                        $("#suggestions").html("");
                    }
                });
            });
        </script>
    </body>
</html>
