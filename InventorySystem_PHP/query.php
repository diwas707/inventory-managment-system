<?php

require_once('includes/session.php');
$msg = $session->msg();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryForm</title>
    <style>
        body {
            font-family: Arial, sans-serif;           
            background-image: url(go.jpg);
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        input:invalid {
            border: 1px solid red;
        }
        input[type="submit"]:disabled {
            background-color: lightgray;
            cursor: not-allowed;
        }
        .message {
            margin-top: 10px;
            font-size: 14px;
            color: green;
        }
        .close-button {
            position: relative;
            top:-70px;
            right:-490px;
            font-size: 20px;
            color: red;
        }
        .close-button:hover {
            color: #333;
        }
        .error {
            color: red;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product Inquiry</h2>
        <a href="index.php" class="close-button">&times;</a>
        
        <form action="auth2.php" method="post" class="clearfix" id="inquiryForm">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <span id="nameError" class="error">Name cannot contain numbers</span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="tel" id="contact" name="contact" pattern="(98|97)\d{8}" title="Please enter a valid 10-digit contact number starting with 98 or 97" required>
            </div>
            <div class="form-group">
                <label for="query">Query:</label>
                <textarea id="query" name="query" required></textarea>
            </div>
            <input type="submit" value="Submit" disabled>
            <?php
            if (!empty($msg)) {
                foreach ($msg as $type => $message) {
                    echo "<div class='message $type'>$message</div>";
                }
            }
            ?>
        </form>
    </div>

    <script>
        const form = document.getElementById('inquiryForm');
        const submitBtn = document.querySelector('input[type="submit"]');
        const nameInput = document.getElementById('name');

        form.addEventListener('input', function() {
            const nameValue = nameInput.value;
            // Check if the name contains numbers
            if (/\d/.test(nameValue)) {
                nameInput.style.border = '1px solid red';
                submitBtn.disabled = true;
            } else {
                nameInput.style.border = '';
                submitBtn.disabled = !form.checkValidity();
            }
        });
    </script>
    
</body>
</html>
