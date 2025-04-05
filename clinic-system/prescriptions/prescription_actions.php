<?php
include_once __DIR__ . '/../includes/db_connect.php'; // Connect to DB

// Start session if needed
// session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- TODO: Input Validation and Sanitization ---
    // Get encounter_id, medication_name, dosage, frequency, duration, notes etc.

    // --- TODO: Determine if Add or Update (if update needed) ---
    $is_update = isset($_POST['prescription_id']) && !empty($_POST['prescription_id']);

    if ($is_update) {
        // --- TODO: Handle Prescription Update ---
        // Get prescription_id and other fields
        // Prepare SQL UPDATE statement
        // Execute statement
        // Set success/error message
    } else {
        // --- TODO: Handle Add New Prescription ---
        // Get form fields
        // Prepare SQL INSERT statement
        // Execute statement
        // Set success/error message
    }

    // --- TODO: Redirect back to encounter page or prescription list ---
    // Redirecting to prescription list for now
    header('Location: index.php');
    exit;

} elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // --- TODO: Handle Prescription Deletion ---
    $prescription_id = $_GET['id'];
    // Prepare SQL DELETE statement
    // Execute statement
    // Set success/error message

    // --- TODO: Redirect back to relevant page ---
    header('Location: index.php'); // Redirect to prescription list
    exit;
} else {
    // Invalid request
    // TODO: Redirect with an error message
    header('Location: index.php');
    exit;
}

// No direct output
?>
