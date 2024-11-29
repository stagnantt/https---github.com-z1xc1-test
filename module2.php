<?php
  include("php/config.php");
  include("php/auth.php"); 
  if(!isset($_SESSION['valid'])){
    header("Location: index.php");
  }

  $id = $_SESSION['id'];

  $stmt = $con->prepare("SELECT * FROM users WHERE Id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()){
    $res_Uname = $row['Username'];
    $res_Email = $row['Email'];
    $res_Age = $row['Age'];
    $res_id = $row['Id'];
    $res_name = $row['Name'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>
<div>
    <div class="nav">
        <div class="logo">
            <a href="home.php">
                <img src="assets/taxi.png" alt="Movers Logo">
            </a>
        </div>
        <div class="right-links">
            <div class="dropdown">
                <button class="dropbtn">Account</button>
                <div class="dropdown-content">
                    <button class="dropcont" onclick="location.href='edit.php?Id=<?php echo $res_id;?>'">Change Profile</button>
                    <button class="dropcont" onclick="location.href='php/logout.php'">Log Out</button>
                </div>
            </div>
        </div>
    </div>
    <div class="side-panel">
        <div class="side-panel-header">
        </div>
        <div class="side-panel-content">
            <div class="module module-1">
                <p class="username"><?php echo $res_Uname;?></p>
                <p><?php echo $res_name;?></p>
                <p class="email"><?php echo $res_Email;?></p>
            </div>
            </div>
            <div class="side-panel-content">
                <div class="module">
                    <button class="module-link" onclick="location.href='home.php'">
                        <i class="fa fa-home" aria-hidden="true"></i> Module 1
                    </button>
                </div>
                <div class="module">
                    <button class="module-link" onclick="location.href='module2.php'">
                        <i class="fa fa-file" aria-hidden="true"></i> Module 2
                    </button>
                </div>
                <div class="module">
                    <button class="module-link" onclick="location.href='module3.php'">
                        <i class="fa fa-cog" aria-hidden="true"></i> Module 3
                    </button>
                </div>
                <div class="module">
                    <button class="module-link" onclick="location.href='module4.php'">
                        <i class="fa fa-cog" aria-hidden="true"></i> Module 4
                    </button>
                </div>
            </div>
        </div>
    </div>
    <main class="main-content">
 <!--dito isusulat modules nyo-->
    </main>
    <script>
        const sidePanel = document.querySelector('.side-panel');
        const mainContent = document.querySelector('.main-content');

        sidePanel.addEventListener('mouseover', () => {
            sidePanel.style.width = '300px';
            mainContent.classList.add('side-panel-hover');
        });

        sidePanel.addEventListener('mouseout', () => {
            sidePanel.style.width = '50px';
            mainContent.classList.remove('side-panel-hover');
        });
    </script>
</body>
</html>