<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Tutor Finder</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="header">
        <h1>Online Tutor Finder</h1>
        <h4>Learn Teach Earn</h4>
    </div>

    <nav>

        <ul>
            <li><a href="newsfeed.php"><img align="center" src="image/home.png"></a></li>
            <li><a href="newsfeed.php">News Feed</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="post.php">Post</a></li>

        </ul>

        <ul class="r">
            <li><a class="active" href="notification.php">Notification</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <form action="#" class="inner">
        <table>
            <tr>
                <th>
                    <h1 align="left" style="margin: 10px;font-size:150%"><label for="">Notification</label></h1>
                </th>
            </tr>
            <tr>
        </table>

        <table>
            <tr>

                <?php
                include 'database_connection.php';
                $id = $_SESSION['id'];
                $q = "SELECT * FROM `notification` WHERE `userId` = $id AND `approve` = 0";
                $query = mysqli_query($conn, $q);
                if ($query->num_rows > 0) {
                    $q = "SELECT notification.nid, registration.id, registration.userName FROM notification JOIN registration on notification.reqId=registration.id WHERE `userId`=$id AND notification.approve = 0";
                    $query = mysqli_query($conn, $q);
                    while ($res = mysqli_fetch_array($query)) {
                ?>
                        <td>
                            <label for=""> <?php echo $res['userName'] ?> has sent you a request </label>
                            </th>

                        </td>
                        <td>
                        <th align="left"><button> <a style="color:white;" href="details.php?id=<?php echo $res['id']; ?>"> Details </a> </button></th>
                        <td>
                        <th align="left"><button> <a style="color:white;" href="acceptReq.php?id=<?php echo $res['nid']; ?>"> Accept </a> </button></th>
                        </td>
                        <td>
                        <th align="left"><button> <a style="color:white;" href="rejectReq.php?id=<?php echo $res['nid']; ?>"> Reject </a> </button></th>
                        </td>
            </tr>
    <?php
                    }
                }
    ?>

    <br>

        </table>

        <?php
        $id = $_SESSION['id'];
        $q = "SELECT * FROM `notification` WHERE `reqId` = $id AND `approve` != 0";
        $query = mysqli_query($conn, $q);
        if ($query->num_rows > 0) {
            $q = "SELECT notification.nid, notification.approve, registration.id, registration.userName FROM notification JOIN registration on notification.userId=registration.id WHERE `reqId`=$id AND notification.approve != 0";
            $query = mysqli_query($conn, $q);
            while ($res = mysqli_fetch_array($query)) {
                $approve = $res['approve'];
                if ($approve == 1) {
        ?>
                    <td>
                        <label for=""> <?php echo $res['userName'] ?> has accepted your request </label>
                    </td>
                    <th align="left"><button> <a style="color:white;" href="details.php?id=<?php echo $res['id']; ?>"> Details </a> </button></th>
                    <br>


                <?php
                } else if ($approve == 2) {

                ?>
                    <td>
                        <label for=""> <?php echo $res['userName'] ?> has rejected your request </label> <br>
                    </td>
        <?php
                }
            }
        }
        ?>



    </form>

</body>

</html>