<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Data through Ajax</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .delete-btn {
            background-color: red;
            color: white;
            border: 0;
            padding: 4px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        #success-message {
            background: #DEF1D8;
            color: green;
            padding: 10px;
            margin: 10px;
            display: none;
            position: absolute;
            right: 15px;
            top: 15px;
        }

        #error-message {
            background: #EFDCDD;
            color: red;
            padding: 10px;
            margin: 10px;
            display: none;
            position: absolute;
            right: 15px;
            top: 15px;
        }
    </style>
</head>

<body>
    <table id="main" border="0" cellspacing="0">
        <tr>
            <td id="header">
                <h1>Add Records with PHP & Ajax</h1>
            </td>
        </tr>
        <tr>
            <td id="table-form">
                <form id="addForm">
                    First Name :<input type="text" id="fname">&nbsp;&nbsp;&nbsp;&nbsp;
                    Last Name :<input type="text" id="lname">
                    <input type="submit" id="save-button" value="Save">
                </form>
            </td>
        </tr>
        <tr>
            <td id="table-data">

            </td>
        </tr>
    </table>
    <div id="error-message"></div>
    <div id="success-message"></div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            function loadTable() {
                $.ajax({
                    url: "../video-1(Read data through Ajax)/ajax-load.php",
                    type: "POST",
                    success: function(data) {
                        $("#table-data").html(data);
                    }
                })
            }
            loadTable();
            $("#save-button").on("click", function(e) {
                e.preventDefault();
                var fname = $("#fname").val();
                var lname = $("#lname").val();
                if (fname == "" || lname == "") {
                    $("#error-message").html("All fields are required").slideDown();
                    $("#success-message").slideUp();
                } else {
                    $.ajax({
                        url: "../video-2(Insertion through Ajax)/ajax-insert.php",
                        type: "POST",
                        data: {
                            first_name: fname,
                            last_name: lname
                        },
                        success: function(data) {
                            if (data == 1) {
                                loadTable();
                                $("#addForm").trigger("reset");
                                $("#success-message").html("Data Inserted Successfully !").slideDown();
                                $("#error-message").slideUp();
                            } else {
                                $("#error-message").html("Can't Save Record").slideDown();
                                $("#success-message").slideUp();
                            }
                        }
                    });
                }
            });

            $(document).on("click", ".delete-btn", function() {
                if (confirm("Do you really want to delete this record ?")) {
                    var studentId = $(this).data("id");
                    var element = this;
                    $.ajax({
                        url: "ajax-delete.php",
                        type: "POST",
                        data: {
                            id: studentId
                        },
                        success: function(data) {
                            if (data) {
                                $(element).closest("tr").fadeOut();
                            } else {
                                $("#error-message").html("Can't Delete record").slideDown();
                                $("#success-message").slideUp();
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>