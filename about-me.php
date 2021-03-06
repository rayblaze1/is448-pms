<?php

session_start();
require_once('config/config.php');

// if the session 'userId' is not set, redirect back to the login page
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
    exit();
}

// using the SESSION userId, get all the data for this user
$pdo = new PDO($CONN_STRING, $USERNAME, $PASSWORD);
$stmt = $pdo->prepare('SELECT * FROM PMSUsers WHERE userId = :userId;');
$stmt->execute(array(':userId' => $_SESSION['userId']));
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include 'includes/bootstrap-scripts.php';?>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="icon" href="favicon.ico">
    <title>About Me</title>
</head>

<body>
    <?php include 'components/sidebar.php';?>
    <div id="mainContent">
        <?php include 'components/navbar.php';?>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col">
                    <h1 class="mb-4 display-4">About Me</h1>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-lg-6 col-xl-4">
                    <h4>First Name</h4>
                    <input class="form-control" value="<?php echo $userInfo['firstName'];?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-lg-6 col-xl-4">
                    <h4>Last Name</h4>
                    <input class="form-control" value="<?php echo $userInfo['lastName'];?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-lg-6 col-xl-4">
                    <h4>Department Name</h4>
                    <input class="form-control" value="<?php echo $userInfo['departmentName'];?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-lg-6 col-xl-4">
                    <h4>Email</h4>
                    <input type="email" class="form-control" value="<?php echo $userInfo['email'];?>" disabled
                        id="emailInput">
                </div>
                <div id="emailDiv" class="col-1 d-flex align-items-end">
                    <button id="emailChangeButton" type="button" class="btn btn-outline-info">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-lg-6 col-xl-4">
                    <h4>Password</h4>
                    <input type="password" class="form-control" value="<?php echo $userInfo['password'];?>" disabled
                        id="passwordInput">
                </div>
                <div id="passwordDiv" class="col-1 d-flex align-items-end">
                    <button id="passwordChangeButton" type="button" class="btn btn-outline-info">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/functions.js"></script>
    <script>

    // get the initial values of the text fields
    let emailInputValue = document.getElementById('emailInput').value;
    let passwordInputValue = document.getElementById('passwordInput').value;

    // get the two "Change" buttons
    let emailChangeButton = document.getElementById('emailChangeButton');
    let passwordChangeButton = document.getElementById('passwordChangeButton');

    // get the two <div>'s that hold the buttons
    let emailDiv = document.getElementById('emailDiv');
    let passwordDiv = document.getElementById('passwordDiv');

    // create two save buttons for saving the state
    let emailSaveButton = document.createElement('button');
    emailSaveButton.classList.add('btn', 'btn-outline-primary', 'mr-1');
    emailSaveButton.innerHTML = `
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
        </svg>`;

    let passwordSaveButton = document.createElement('button');
    passwordSaveButton.classList.add('btn', 'btn-outline-primary', 'mr-1');
    passwordSaveButton.innerHTML = `
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
        </svg>`;

    // create two cancel buttons for cancelling the action
    let emailCancelButton = document.createElement('button');
    emailCancelButton.classList.add('btn', 'btn-outline-danger');
    emailCancelButton.innerHTML = `
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>`;

    let passwordCancelButton = document.createElement('button');
    passwordCancelButton.classList.add('btn', 'btn-outline-danger');
    passwordCancelButton.innerHTML = `
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>`;

    // event listener for the email "Change" button
    emailChangeButton.addEventListener('click', function() {
        // set the corresponding input to enabled
        document.getElementById('emailInput').disabled = false;

        // put the two buttons into the corresponding <div>
        emailDiv.innerHTML = '';
        emailDiv.append(emailSaveButton);
        emailDiv.append(emailCancelButton);
    });

    // event listener for the password "Change" button
    passwordChangeButton.addEventListener('click', function() {
        // set the corresponding input to enabled + show text
        document.getElementById('passwordInput').disabled = false;
        document.getElementById('passwordInput').type = 'text';

        // put the two buttons into the corresponding <div>
        passwordDiv.innerHTML = '';
        passwordDiv.append(passwordSaveButton);
        passwordDiv.append(passwordCancelButton);
    });

    // event listener for the email "Save" button
    emailSaveButton.addEventListener('click', function() {

        // Check if the email is valid - if it isn't, render an email to the user
        if (!validateEmail(document.getElementById('emailInput').value)) {
            alert('Please enter a valid email!');
            return;
        }

        // set the value for the 'emailInputValue'
        emailInputValue = document.getElementById('emailInput').value;

        // make a POST request to the update email file
        $.post('actions/update-email.php', {
            userId: <?php echo $_SESSION['userId'] ?>,
            email: emailInputValue
        });

        // disable the text field
        document.getElementById('emailInput').disabled = true;

        // remove the buttons and add the cancel button instead
        emailDiv.innerHTML = '';
        emailDiv.append(emailChangeButton);
    });

    // event listener for the email "Cancel" button
    emailCancelButton.addEventListener('click', function() {
        // set the value of the text field to its initial value
        document.getElementById('emailInput').value = emailInputValue;

        // disable the text field
        document.getElementById('emailInput').disabled = true;

        // remove the buttons from the div and add the cancel button instead
        emailDiv.innerHTML = '';
        emailDiv.append(emailChangeButton);
    });

    // event listener for the password "Save" button
    passwordSaveButton.addEventListener('click', function() {

        // Check if the password is blank - if it is, alert the user
        if (document.getElementById('passwordInput').value == '') {
            alert('Please enter a valid password!');
            return;
        }

        // set the value for the 'passwordInputValue'
        passwordInputValue = document.getElementById('passwordInput').value;

        // make a POST request to the update password file
        $.post('actions/update-password.php', {
            userId: <?php echo $_SESSION['userId'] ?>,
            password: passwordInputValue
        });

        // disable the text field and set the type to "password"
        document.getElementById('passwordInput').type = 'password'
        document.getElementById('passwordInput').disabled = true;

        // remove the buttons and add the cancel button instead
        passwordDiv.innerHTML = '';
        passwordDiv.append(passwordChangeButton);
    });

    // event listener for the password "Cancel" button
    passwordCancelButton.addEventListener('click', function() {
        // set the value of the text value to its initial value
        document.getElementById('passwordInput').value = passwordInputValue;

        // disable the text field and set type to "password"
        document.getElementById('passwordInput').type = 'password'
        document.getElementById('passwordInput').disabled = true;

        // remove the buttons from the div and add the change button
        passwordDiv.innerHTML = '';
        passwordDiv.append(passwordChangeButton);
    });
    </script>
</body>

</htmL>