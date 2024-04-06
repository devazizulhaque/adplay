<?php

// Include the BidRequest class
require_once 'classes/Campaign.php';

// Create an instance of the Campaign class
$campaign = new Campaign();

// Get the bid response
$response = $campaign->getBidResponse();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTB Banner Campaign Response</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>RTB Banner Campaign Response</h1>
        <div id="response">
            <pre><?php echo $response; ?></pre>
        </div>
    </div>
</body>
</html>
