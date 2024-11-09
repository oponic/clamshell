<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Create students directory if it doesn't exist
if (!file_exists('./cellar/students')) {
    mkdir('./cellar/students', 0755, true);
}

// Load teacher data
$teachers = [];
$teacherFiles = glob('./cellar/teachers/*.json');
foreach ($teacherFiles as $file) {
    $teacherData = json_decode(file_get_contents($file), true);
    $teachers[] = $teacherData;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentConfig = [
        'name' => $_POST['student_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'grade' => $_POST['grade'] ?? '',
        'teacher_email' => $_POST['teacher'] ?? '',
    ];
    
    $safeFilename = preg_replace('/[^a-z0-9]/', '_', strtolower($_POST['email']));
    $jsonConfig = json_encode($studentConfig, JSON_PRETTY_PRINT);
    file_put_contents("./cellar/students/{$safeFilename}.json", $jsonConfig);

    echo "<div class='success-message'>Thank you! Your information has been saved successfully.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 0 20px; background-color: #f5f5f5; }
        .form-group { margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .help-text { font-size: 14px; color: #666; margin-top: 5px; }
        button { background: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #45a049; }
        .success-message { background: #4CAF50; color: white; padding: 15px; border-radius: 4px; text-align: center; }
        h1 { color: #333; text-align: center; }
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .checkbox-label input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }
        .other-subjects {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Student Registration Form</h1>
    <form method="POST">
        <div class="form-group">
            <label for="teacher">Select Your Teacher:</label>
            <select name="teacher" id="teacher" required>
                <option value="">Choose your teacher...</option>
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo htmlspecialchars($teacher['email']); ?>">
                        <?php echo htmlspecialchars($teacher['name']); ?> - 
                        Grade <?php echo htmlspecialchars($teacher['grade']); ?> - 
                        Room <?php echo htmlspecialchars($teacher['room_number']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="student_name">Your Full Name:</label>
            <input type="text" name="student_name" id="student_name" required>
            <div class="help-text">Please enter your first and last name</div>
        </div>

        <div class="form-group">
            <label for="email">Your School Email:</label>
            <input type="email" name="email" id="email" required>
            <div class="help-text">This will be used for school communications</div>
        </div>

        <div class="form-group">
            <label for="grade">Your Grade:</label>
            <select name="grade" id="grade" required>
                <option value="">Select your grade...</option>
                <?php for($i = 8; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>">Grade <?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>
