<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Profile Permission</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo base_url(); ?>assets/img/favicon.png" rel="icon">
    <link href="<?php echo base_url(); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    <style>
        .custom-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }

        .custom-button.verified {
            background-color: green;
        }

        .custom-button.unverified {
            background-color: red;
        }
    </style>

</head>

<?php include APPPATH . 'Views/includes/header.php'; ?>
<?php include APPPATH . 'Views/includes/sidebar.php'; ?>

<body>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Profile Permission</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Bond In/Out</li>
                    <li class="breadcrumb-item active">Bond Transaction</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Permission</h5>

                            <div class="d-flex justify-content-center">
                                <div class="btn-group">
                                    <button class="btn btn-light btn-lg rounded border dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="selectedProfileBtn" data-profile-id="">
                                        Select Profile
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($profiles as $profile) : ?>
                                            <li><a class="dropdown-item" href="#" data-profile-id="<?= $profile['profile_id'] ?>" onclick="selectProfile(this)"><?= $profile['profile_role'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-3" id="modulesContainer">
                                <table id="permissionsTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 200px; background-color: #0D6EFD; color: white">Module</th>
                                            <th style="width: 200px; background-color: #0D6EFD; color: white">Add</th>
                                            <th style="width: 200px; background-color: #0D6EFD; color: white">View</th>
                                            <th style="width: 200px; background-color: #0D6EFD; color: white">Edit</th>
                                            <th style="width: 200px; background-color: #0D6EFD; color: white">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <?php include APPPATH . 'Views/includes/footer.php'; ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?php echo base_url(); ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/chart.js/chart.umd.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/echarts/echarts.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/quill/quill.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function selectProfile(clickedElement) {
            var profileId = clickedElement.getAttribute('data-profile-id');
            var profileRole = clickedElement.innerText;

            document.getElementById('selectedProfileBtn').innerHTML = profileRole;
            document.getElementById('selectedProfileBtn').setAttribute('data-profile-id', profileId);

            fetchPermissions(profileId);
        }

        function fetchPermissions(profileId) {
    $.ajax({
        url: 'profilepermission/getPermissionsByProfile/' + profileId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response && response.length > 0) {
                displayPermissions(response);
            } else {
                console.error('No permissions found');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching permissions:', error);
            console.log(xhr.responseText);  // Log the full responseText for more details
        }
    });
}


        function displayPermissions(permissions) {
            // Assume you have a table with the id 'permissionsTable'
            var table = document.getElementById('permissionsTable');
            clearTable(table);

            permissions.forEach(function (permission) {
                // Add a new row to the table
                var row = table.insertRow(-1);

                // Add cells for module and actions
                var moduleCell = row.insertCell(0);
                var addActionCell = row.insertCell(1);
                var viewActionCell = row.insertCell(2);
                var editActionCell = row.insertCell(3);
                var deleteActionCell = row.insertCell(4);

                moduleCell.innerHTML = permission.profiledashboard_id; // Change this line
                addActionCell.innerHTML = createToggleButton('Add', permission.add_dashboard);
                viewActionCell.innerHTML = createToggleButton('View', permission.view_dashboard);
                editActionCell.innerHTML = createToggleButton('Edit', permission.edit_dashboard);
                deleteActionCell.innerHTML = createToggleButton('Delete', permission.delete_dashboard);
            });
        }
 function createToggleButton(action, status) {
    var buttonClass = status == 1 ? 'btn-success' : 'btn-danger';
    var buttonText = status == 1 ? 'Yes' : 'No';

    return '<button class="btn ' + buttonClass + '">' + buttonText + '</button>';
}


        function clearTable(table) {
          
            while (table.rows.length > 1) {
                table.deleteRow(1);
            }
        }
    </script>

</body>

</html>
