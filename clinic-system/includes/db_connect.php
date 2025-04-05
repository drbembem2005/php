<?php
// Database configuration
$db_path = __DIR__ . '/../db/clinic.db'; // Path relative to this file
$dsn = 'sqlite:' . $db_path;
$pdo = null; // Initialize PDO variable

try {
    // Create (connect to) the database file and get PDO object
    $pdo = new PDO($dsn);

    // Set errormode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Optional: Enable foreign key constraints for SQLite (recommended)
    $pdo->exec('PRAGMA foreign_keys = ON;');

    // echo "Database connection successful!"; // Uncomment for testing

    // --- Initial Table Creation (Run only once) ---
    // Check if tables exist, if not, create them.
    // This is a simple way for initial setup. In a real app, use migrations.

    $tables = [
        'patients' => 'CREATE TABLE IF NOT EXISTS patients (
                            patient_id INTEGER PRIMARY KEY AUTOINCREMENT,
                            first_name TEXT NOT NULL,
                            last_name TEXT NOT NULL,
                            dob TEXT,
                            gender TEXT,
                            phone TEXT,
                            email TEXT UNIQUE,
                            address TEXT,
                            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                        )',
        'staff' => 'CREATE TABLE IF NOT EXISTS staff (
                        staff_id INTEGER PRIMARY KEY AUTOINCREMENT,
                        first_name TEXT NOT NULL,
                        last_name TEXT NOT NULL,
                        role TEXT NOT NULL,
                        phone TEXT,
                        email TEXT UNIQUE NOT NULL,
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    )',
        'users' => 'CREATE TABLE IF NOT EXISTS users (
                        user_id INTEGER PRIMARY KEY AUTOINCREMENT,
                        username TEXT UNIQUE NOT NULL,
                        password_hash TEXT NOT NULL,
                        staff_id INTEGER,
                        role TEXT NOT NULL,
                        is_active INTEGER DEFAULT 1,
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE SET NULL
                    )',
        'appointments' => 'CREATE TABLE IF NOT EXISTS appointments (
                                appointment_id INTEGER PRIMARY KEY AUTOINCREMENT,
                                patient_id INTEGER NOT NULL,
                                staff_id INTEGER,
                                appointment_time DATETIME NOT NULL,
                                reason TEXT,
                                status TEXT DEFAULT \'Scheduled\',
                                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
                                FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE SET NULL
                            )',
        'encounters' => 'CREATE TABLE IF NOT EXISTS encounters (
                            encounter_id INTEGER PRIMARY KEY AUTOINCREMENT,
                            patient_id INTEGER NOT NULL,
                            staff_id INTEGER NOT NULL,
                            appointment_id INTEGER,
                            encounter_time DATETIME DEFAULT CURRENT_TIMESTAMP,
                            chief_complaint TEXT,
                            diagnosis TEXT,
                            notes TEXT,
                            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
                            FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE RESTRICT,
                            FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE SET NULL
                        )',
        'prescriptions' => 'CREATE TABLE IF NOT EXISTS prescriptions (
                                prescription_id INTEGER PRIMARY KEY AUTOINCREMENT,
                                encounter_id INTEGER NOT NULL,
                                medication_name TEXT NOT NULL,
                                dosage TEXT,
                                frequency TEXT,
                                duration TEXT,
                                notes TEXT,
                                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                FOREIGN KEY (encounter_id) REFERENCES encounters(encounter_id) ON DELETE CASCADE
                            )',
        'billing' => 'CREATE TABLE IF NOT EXISTS billing (
                            bill_id INTEGER PRIMARY KEY AUTOINCREMENT,
                            encounter_id INTEGER NOT NULL,
                            patient_id INTEGER NOT NULL,
                            total_amount REAL NOT NULL,
                            amount_paid REAL DEFAULT 0.0,
                            payment_status TEXT DEFAULT \'Unpaid\',
                            bill_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                            due_date DATETIME,
                            notes TEXT,
                            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (encounter_id) REFERENCES encounters(encounter_id) ON DELETE RESTRICT,
                            FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE
                        )'
    ];

    foreach ($tables as $table_name => $sql) {
        $pdo->exec($sql);
        // echo "Table '$table_name' checked/created successfully.<br>"; // Uncomment for testing
    }

} catch (PDOException $e) {
    // If connection fails, display error message
    // In production, log this error instead of showing it to the user
    // Use htmlspecialchars to prevent potential issues if error message contains special chars
    $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    $errorDsn = htmlspecialchars($dsn, ENT_QUOTES, 'UTF-8');
    die("Database connection failed: " . $errorMessage . " (DSN: " . $errorDsn . ")");
}

// The $pdo variable is now available for use in other included files.
