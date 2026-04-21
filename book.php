<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to book a ticket.";
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $db_connected) {

    $bus_id = $_POST['bus_id'];
    $date = $_POST['date'];
    $passengers = $_POST['passengers'];
    $total_amount = $_POST['total_amount'];
    $user_id = $_SESSION['user_id'];
    $booking_ref = "B" . rand(1000, 9999);

    $payload = [
        'booking_reference' => $booking_ref,
        'user_id' => (int)$user_id,
        'bus_id' => (int)$bus_id,
        'journey_date' => $date,
        'passengers' => (int)$passengers,
        'total_amount' => (float)$total_amount,
        'status' => 'Confirmed'
    ];

    $res = supabase_request('POST', '/bookings', $payload);
    
    if ($res['status'] >= 200 && $res['status'] < 300) {
        $_SESSION['success'] = "Booking Successful! Your Reference ID is: " . $booking_ref;
        header("Location: index.php");
        exit();
    } else {
        echo "Error creating booking via Supabase.";
        echo "<pre>"; print_r($res); echo "</pre>";
    }
} else {
    echo "Direct access not allowed or DB not connected.";
}
?>
