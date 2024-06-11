<?php

@include 'constants.php';

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

$PRSN_ID = $_SESSION['prsn_id'];

$employee_status = isset($_GET['type']) ? $_GET['type'] : 'all';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Employees | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header class="backend">
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
                    <p>ADMIN</p>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-inventory.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
                <!-- Text below should change to 'Logout'once user logged in-->
                <?php
                if (isset($_SESSION['prsn_id'])) {
                ?>
                    <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                    </li>
                <?php
                } else {
                ?>
                    <li><a href="<?php echo SITEURL; ?>login-page.php">Login</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </header>
    <main>
        <section class="section">
            <div class="container">
                <div class="section-heading">
                    <h2>Employees</h2>
                    <div class="inline">
                        <p>Filter:</p>
                        <select name="employee-status" id="employee-status" class="dropdown">
                            <option value="all" <?php echo ($employee_status === 'all') ? 'selected' : ''; ?>>All</option>
                            <option value="Active" <?php echo ($employee_status === 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($employee_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <script>
                    document.getElementById('employee-status').addEventListener('change', function() {
                        var selectedEmployeeStatus = this.value;
                        window.location.href = "admin-employee-accounts.php?type=" + selectedEmployeeStatus;
                    });
                </script>

                <section class="section-body">
                    <section class="main-section column">
                        <div class="table-wrapper">
                            <table class="alternating">
                                <tr>
                                    <th class="header">Picture</th>
                                    <th class="header">First Name</th>
                                    <th class="header">Last Name</th>
                                    <th class="header">Contact #</th>
                                    <th class="header">Username</th>
                                    <th class="header">Status</th>
                                    <th class="header">Action</th>
                                </tr>
                                <?php

                                $employee_status = isset($_GET['type']) ? $_GET['type'] : 'all';

                                $sql = "SELECT *
                                FROM person
                                INNER JOIN employee ON person.PRSN_ID = employee.PRSN_ID";

                                if ($employee_status === 'all') {
                                    $sql .= " WHERE person.PRSN_ROLE = 'Employee' OR person.PRSN_ROLE = 'Admin'";
                                } else {
                                    $sql .= " WHERE (person.PRSN_ROLE = 'Employee' OR person.PRSN_ROLE = 'Admin') AND employee.EMP_STATUS = '$employee_status'";
                                }


                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $PRSN_ID = $row['PRSN_ID'];
                                        $EMP_ID = $row['EMP_ID'];
                                        $EMP_IMAGE = $row['EMP_IMAGE'];
                                        $EMP_FNAME = $row['EMP_FNAME'];
                                        $EMP_LNAME = $row['EMP_LNAME'];
                                        $PRSN_NUMBER = $row['PRSN_PHONE'];
                                        $PRSN_NAME = $row['PRSN_NAME'];
                                        $PRSN_EMAIL = $row['PRSN_EMAIL'];
                                        $EMP_STATUS = $row['EMP_STATUS'];
                                ?>
                                        <tr>
                                            <td data-cell="Image">
                                                <img src="<?php echo SITEURL; ?>images/<?php echo $EMP_IMAGE; ?>" alt="">
                                            </td>
                                            <td data-cell="Name"><?php echo $EMP_FNAME ?></td>
                                            <td data-cell="Name"><?php echo $EMP_LNAME ?></td>
                                            <td data-cell="Contact #"><?php echo $PRSN_NUMBER ?></td>
                                            <td data-cell="Username"><?php echo $PRSN_EMAIL ?></td>
                                            <td data-cell="Status"><?php echo $EMP_STATUS ?></td>
                                            <td data-cell="Action"><a href="<?php echo SITEURL; ?>admin-edit-employee.php?PRSN_ID=<?php echo $PRSN_ID ?>&EMP_ID=<?php echo $EMP_ID ?>" class="edit">Edit</a></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="error">Empty</td>
                                    </tr>
                                <?php

                                }
                                ?>
                            </table>
                        </div>
                        <a href="<?php echo SITEURL; ?>admin-add-employee.php" class="page-btn"><button class="big-btn">Add a new employee</button></a>
                    </section>
                </section>
            </div>
        </section>
    </main>
</body>

</html>