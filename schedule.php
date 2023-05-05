<!-- ALL JOHN -->
<!-- This file creates the calendar view -->
<!-- It queries the DB to find relevant events to the user and displays them -->
<?php 
    include "db_connection.php";

    $user_id = $_GET['userid'];
    $mondayTS = $_GET['monday'];

    // Obtain the user level to determine admin privileges
    // Can utilize the isAdmin index, which consists of level and user_id
    $user_sql = "SELECT users.level FROM users WHERE users.user_id = $user_id LIMIT 1";
    $user = $conn->query($user_sql);
    $userRow = mysqli_fetch_array($user);

    date_default_timezone_set('America/Chicago');

    // Determine remaining days of the week and format to display
    $tuesdayTS =  strtotime('+1 days', $mondayTS);
    $wednesdayTS = strtotime('+1 days', $tuesdayTS);
    $thursdayTS = strtotime('+1 days', $wednesdayTS);
    $fridayTS = strtotime('+1 days', $thursdayTS);
    $monday = date('m/d', $mondayTS);
    $tuesday = date('m/d', $tuesdayTS);
    $wednesday = date('m/d', $wednesdayTS);
    $thursday = date('m/d', $thursdayTS);
    $friday = date('m/d', $fridayTS);

    // Set up the previous / next week buttons
    $prevMonday = strtotime('-7 days', $mondayTS);
    $nextMonday = strtotime('+7 days', $mondayTS);

    // Select meetings that the current user is invited to
    $sql = " SELECT events.event_id, events.date, events.location, events.name, events.project_id, events.time, events.user_id FROM events INNER JOIN event_attendee ON event_attendee.event_id = events.event_id WHERE event_attendee.user_id = $user_id";
    // If the user is an admin, they can see every event
    if ($userRow["level"] == 1) {
        $sql = " SELECT * from events";
    }
    $result = $conn->query($sql);

    // Arrays for each day of the week
    // We separate the queried event data to match the visual separation by day of week that is present on the schedule page
    $mondays = [];
    $tuesdays = [];
    $wednesdays = [];
    $thursdays = [];
    $fridays = [];

    // Loop through each event queried above
    while ( $row = mysqli_fetch_array($result) ) {
        // Get the date
        $timestamp = strtotime($row["date"]);

        // Convert the project id into a displayable name
        $project_id = $row["project_id"];
        $project_sql = "SELECT project_name FROM projecttitle WHERE projecttitle.project_id = $project_id LIMIT 1";
        $project = $conn->query($project_sql);
        $projRow = mysqli_fetch_array($project);

        // Convert the user id into a displayable name
        $maker_id = $row["user_id"];
        $maker_sql = "SELECT first_name, last_name FROM username WHERE username.user_id = $maker_id LIMIT 1";
        $maker = $conn->query($maker_sql);
        $makerRow = mysqli_fetch_array($maker);

        // Specifically for admin functionality, determine if the queried event is one they're attending
        $event_id = $row["event_id"];
        // Checks if the current event_id and user_id exist together in the bridge entity
        $event_sql = "SELECT user_id FROM event_attendee WHERE event_attendee.user_id = $user_id AND event_attendee.event_id = $event_id";
        $event_conn = $conn->query($event_sql);
        $attending = true;
        if (mysqli_num_rows($event_conn) == 0) { // if the entity instance did not exist, the user is not attending this event
            $attending = false;
        }

        // Place the queried data into the appropriate day of the week array
        // Only places data for the current week, as specified by the timestamps
        if ($timestamp == $mondayTS) {
            $mondays[] = [$row["event_id"], $projRow["project_name"], $row["user_id"], $row["time"], $row["location"], $row["name"], $makerRow["first_name"], $makerRow["last_name"], $attending];
        }
        if ($timestamp == $tuesdayTS) {
            $tuesdays[] = [$row["event_id"], $projRow["project_name"], $row["user_id"], $row["time"], $row["location"], $row["name"], $makerRow["first_name"], $makerRow["last_name"], $attending];
        }
        if ($timestamp == $wednesdayTS) {
            $wednesdays[] = [$row["event_id"], $projRow["project_name"], $row["user_id"], $row["time"], $row["location"], $row["name"], $makerRow["first_name"], $makerRow["last_name"], $attending];
        }
        if ($timestamp == $thursdayTS) {
            $thursdays[] = [$row["event_id"], $projRow["project_name"], $row["user_id"], $row["time"], $row["location"], $row["name"], $makerRow["first_name"], $makerRow["last_name"], $attending];
        }
        if ($timestamp == $fridayTS) {
            $fridays[] = [$row["event_id"], $projRow["project_name"], $row["user_id"], $row["time"], $row["location"], $row["name"], $makerRow["first_name"], $makerRow["last_name"], $attending];
        }
    }

    // Sort the arrays based on the time
    usort($mondays, fn($a, $b) => $a[3] <=> $b[3]);
    usort($tuesdays, fn($a, $b) => $a[3] <=> $b[3]);
    usort($wednesdays, fn($a, $b) => $a[3] <=> $b[3]);
    usort($thursdays, fn($a, $b) => $a[3] <=> $b[3]);
    usort($fridays, fn($a, $b) => $a[3] <=> $b[3]);
?> 

<html>
    <!-- Standard home and add buttons present on most pages -->
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id; ?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>

        <a href="event.php?userid=<?php echo $user_id; ?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:30; right:375;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
            </button>
        </a>
        <h1 align="center"> Schedule </h1>
        <br>
    </head>
</html>

<div class="container">
    <!-- Next and previous week buttons; reloads the page with new timestamps -->
    <div class="row" style="display: flex; justify-content: space-between;">
        <a href= "schedule.php?userid=<?php echo $user_id; ?>&monday=<?php echo $prevMonday; ?> " style="color:black"> Last Week </a>
        <div style="background-color:#000000; height:5px; width:30%; margin-top:5px"></div>
        <a href= "schedule.php?userid=<?php echo $user_id; ?>&monday=<?php echo $nextMonday; ?>" style="color:black"> Next Week </a>
    </div>    
    <div class="row-fluid " style="display: flex; justify-content: center;">
        <div class="col-sm-2 " style="display: flex; flex-direction: column; align-items: center;">
            <h4> Monday  <?php echo $monday?> </h4>
            <!-- Loops through all the monday events -->
            <?php foreach($mondays as $event): ?>
                <div class="card-columns-fluid">
                        <div class="card bg-light" style = "width: 15rem; height: 15rem " >
                            <div class="card-body" style="overflow: scroll">
                                <!-- Visually distinguish which events an admin is attending,
                                since all events appear on their page. $event[8] represents the true/false bool -->
                                <?php if($userRow["level"] == 1 and $event[8]): ?>
                                    <h7 style="color:red"> Attending! </h7>
                                    <br>
                                <?php endif; ?>
                                <!-- Combines the first and last names -->
                                <small style="white-space: nowrap;">Creator: <?php echo $event[6]?>  <?php echo " "?> <?php echo $event[7]?></small>
                                <br>
                                <!-- Creates the edit and delete buttons for events that the user created.
                                Admins have these buttons for every event -->
                                <?php if($event[2] == $user_id or $userRow["level"] == 1): ?>
                                    <a href="eventupdate.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:black; border:3px solid;">Edit Meeting</a>
                                    <a href="deleteevent.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:red;">X</a>
                                    <br>
                                <?php endif; ?> 
                                <h7 style="white-space: nowrap;"> Name: <?php echo $event[5]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Location: <?php echo $event[4]?></h7>
                                <br>
                                <h7> Time: <?php echo $event[3]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Project: <?php echo $event[1]?></h7>
                            </div>
                        </div>
                </div>
                </br> 
            <?php endforeach; ?> 
        </div>
        <!-- Similar logic as Monday is implemented for every day of the week -->
        <div class="col-sm-2 " style="display: flex; flex-direction: column; align-items: center;">
            <h4> Tuesday <?php echo $tuesday?> </h4>
            <?php foreach($tuesdays as $event): ?>
                <div class="card-columns-fluid">
                        <div class="card bg-light" style = "width: 15rem; height: 15rem " >
                            <div class="card-body" style="overflow: scroll">
                                <?php if($userRow["level"] == 1 and $event[8]): ?>
                                    <h7 style="color:red"> Attending! </h7>
                                    <br>
                                <?php endif; ?>
                                <small style="white-space: nowrap;">Creator: <?php echo $event[6]?>  <?php echo " "?> <?php echo $event[7]?></small>
                                <br>
                                <?php if($event[2] == $user_id or $userRow["level"] == 1): ?>
                                    <a href="eventupdate.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:black; border:3px solid;">Edit Meeting</a>
                                    <a href="deleteevent.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:red; ">X</a>
                                    <br>
                                <?php endif; ?> 
                                <h7 style="white-space: nowrap;"> Name: <?php echo $event[5]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Location: <?php echo $event[4]?></h7>
                                <br>
                                <h7> Time: <?php echo $event[3]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Project: <?php echo $event[1]?></h7>
                            </div>
                        </div>
                </div>
                </br> 
            <?php endforeach; ?> 
        </div>
        <div class="col-sm-2 " style="display: flex; flex-direction: column; align-items: center;">
            <h4> Wednesday <?php echo $wednesday?> </h4>
            <?php foreach($wednesdays as $event): ?>
                <div class="card-columns-fluid">
                        <div class="card bg-light" style = "width: 15rem; height: 15rem " >
                            <div class="card-body" style="overflow: scroll">
                                <?php if($userRow["level"] == 1 and $event[8]): ?>
                                    <h7 style="color:red"> Attending! </h7>
                                    <br>
                                <?php endif; ?>
                                <small style="white-space: nowrap;">Creator: <?php echo $event[6]?>  <?php echo " "?> <?php echo $event[7]?></small>
                                <br>
                                <?php if($event[2] == $user_id or $userRow["level"] == 1): ?>
                                    <a href="eventupdate.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:black; border:3px solid;">Edit Meeting</a>
                                    <a href="deleteevent.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:red; ">X</a>
                                    <br>
                                <?php endif; ?> 
                                <h7 style="white-space: nowrap;"> Name: <?php echo $event[5]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Location: <?php echo $event[4]?></h7>
                                <br>
                                <h7> Time: <?php echo $event[3]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Project: <?php echo $event[1]?></h7>
                            </div>
                        </div>
                </div>
                </br> 
            <?php endforeach; ?> 
        </div>
        <div class="col-sm-2 " style="display: flex; flex-direction: column; align-items: center;">
            <h4> Thursday <?php echo $thursday?> </h4>
            <?php foreach($thursdays as $event): ?>
                <div class="card-columns-fluid">
                        <div class="card bg-light" style = "width: 15rem; height: 15rem " >
                            <div class="card-body" style="overflow: scroll">
                                <?php if($userRow["level"] == 1 and $event[8]): ?>
                                    <h7 style="color:red"> Attending! </h7>
                                    <br>
                                <?php endif; ?>
                                <small style="white-space: nowrap;">Creator: <?php echo $event[6]?>  <?php echo " "?> <?php echo $event[7]?></small>
                                <br>
                                <?php if($event[2] == $user_id or $userRow["level"] == 1): ?>
                                    <a href="eventupdate.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:black; border:3px solid;">Edit Meeting</a>
                                    <a href="deleteevent.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:red; ">X</a>
                                    <br>
                                <?php endif; ?> 
                                <h7 style="white-space: nowrap;"> Name: <?php echo $event[5]?></h7>
                                <br>
                                <h7> Location: <?php echo $event[4]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Time: <?php echo $event[3]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Project: <?php echo $event[1]?></h7>
                            </div>
                        </div>
                </div>
                </br>  
            <?php endforeach; ?> 
        </div>
        <div class="col-sm-2 " style="display: flex; flex-direction: column; align-items: center;">
            <h4> Friday <?php echo $friday?> </h4>
            <?php foreach($fridays as $event): ?>
                <div class="card-columns-fluid">
                        <div class="card bg-light" style = "width: 15rem; height: 15rem " >
                            <div class="card-body" style="overflow: scroll">
                                <?php if($userRow["level"] == 1 and $event[8]): ?>
                                    <h7 style="color:red"> Attending! </h7>
                                    <br>
                                <?php endif; ?>
                                <small style="white-space: nowrap;">Creator: <?php echo $event[6]?>  <?php echo " "?> <?php echo $event[7]?></small>
                                <br>
                                <?php if($event[2] == $user_id or $userRow["level"] == 1): ?>
                                    <a href="eventupdate.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:black; border:3px solid;">Edit Meeting</a>
                                    <a href="deleteevent.php?event_id=<?php echo $event[0] ?>&userid=<?php echo $user_id ?>" style="color:red;">X</a>
                                    <br>
                                <?php endif; ?> 
                                <h7 style="white-space: nowrap;"> Name: <?php echo $event[5]?></h7>
                                <br>
                                <h7> Location: <?php echo $event[4]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Time: <?php echo $event[3]?></h7>
                                <br>
                                <h7 style="white-space: nowrap;"> Project: <?php echo $event[1]?></h7>
                            </div>
                        </div>
                </div>
                </br> 
            <?php endforeach; ?> 
        </div>
    </div>
</div>
