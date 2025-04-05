<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../includes/header.php';

// TODO: Check if editing (load existing patient data) or adding new
$is_editing = false;
$patient_data = []; // Placeholder for existing data if editing

// TODO: Handle form submission via patient_actions.php
?>

<h1><?php echo $is_editing ? 'Edit Patient' : 'Add New Patient'; ?></h1>

<form action="patient_actions.php" method="POST">
    <!-- TODO: Add hidden input for patient_id if editing -->
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    <!-- TODO: Add other patient fields (dob, gender, phone, email, address) -->
    <button type="submit" class="btn btn-primary"><?php echo $is_editing ? 'Update Patient' : 'Add Patient'; ?></button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php
include_once __DIR__ . '/../includes/footer.php';
?>
