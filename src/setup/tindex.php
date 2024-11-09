<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!file_exists('./cellar/teachers')) {
    mkdir('./cellar/teachers', 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get selected subjects and combine with "other" subjects
    $subjects = $_POST['subjects'] ?? [];
    if (!empty($_POST['other_subjects'])) {
        $otherSubjects = array_map('trim', explode(',', $_POST['other_subjects']));
        $subjects = array_merge($subjects, $otherSubjects);
    }

    $teacherConfig = [
        'name' => $_POST['teacher_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'grade' => $_POST['grade'] ?? '',
        'subjects' => $subjects,
        'room_number' => $_POST['room_number'] ?? ''
    ];
    
    // Create a safe filename from teacher's email
    $safeFilename = preg_replace('/[^a-z0-9]/', '_', strtolower($_POST['email']));
    $jsonConfig = json_encode($teacherConfig, JSON_PRETTY_PRINT);
    file_put_contents("./cellar/teachers/{$safeFilename}.json", $jsonConfig);

    echo "<div class='success-message'>Thank you! Your information has been saved successfully.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Registration</title>
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
    <h1>Teacher Registration Form</h1>
    <form method="POST">
        <div class="form-group">
            <label for="teacher_name">Your Full Name:</label>
            <input type="text" name="teacher_name" id="teacher_name" required>
            <div class="help-text">Please enter your first and last name</div>
        </div>

        <div class="form-group">
            <label for="email">Your School Email:</label>
            <input type="email" name="email" id="email" required>
            <div class="help-text">This will be used for school communications</div>
        </div>

        <div class="form-group">
            <label for="grade">What grade do you teach?</label>
            <select name="grade" id="grade" required>
                <option value="">Select a grade...</option>
                <?php for($i = 8; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>">Grade <?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Subjects you teach:</label>
            <div class="checkbox-group">
                <?php
                $commonSubjects = [
                    'Math' => 'Mathematics',
                    'English' => 'English',
                    'Science' => 'Science',
                    'History' => 'History',
                    'Geography' => 'Geography',
                    'Physics' => 'Physics',
                    'Chemistry' => 'Chemistry',
                    'Biology' => 'Biology',
                    'Art' => 'Art',
                    'Music' => 'Music',
                    'PhysEd' => 'Physical Education',
                    'CompSci' => 'Computer Science'
                ];
                
                foreach ($commonSubjects as $value => $label): 
                ?>
                    <label class="checkbox-label">
                        <input type="checkbox" name="subjects[]" value="<?php echo $value; ?>">
                        <?php echo $label; ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="other-subjects">
                <label for="other_subjects">Other Subjects:</label>
                <input type="text" name="other_subjects" id="other_subjects">
                <div class="help-text">Enter additional subjects separated by commas (e.g., French, Drama, Economics)</div>
            </div>
        </div>

        <div class="form-group">
            <label for="room_number">Room Number:</label>
            <input type="text" name="room_number" id="room_number" required>
            <div class="help-text">Your classroom number</div>
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>
