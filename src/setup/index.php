<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!file_exists('./cellar')) {
    mkdir('./cellar', 0755, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = [
        'environment' => $_POST['environment'] ?? 'development',
        'name' => $_POST['name'] ?? 'playground-highschool',
        'grades-offered' => array_map('intval', $_POST['grades'] ?? [9, 10, 11, 12]),
        'setup' => "2",
        'adm-mail' => $_POST['adm_mail'] ?? ''
    ];
    
    $features = [
        'campus_map' => [
            'enabled' => isset($_POST['feature_campus_map']),
            'multiple_buildings' => isset($_POST['campus_map_multiple_buildings']),
            'time_restricted' => isset($_POST['campus_map_time_restricted']),
            'available_from' => $_POST['campus_map_from'] ?? '07:00',
            'available_until' => $_POST['campus_map_until'] ?? '18:00'
        ]
        // Add more features here as needed
    ];
    
    $jsonConfig = json_encode($config, JSON_PRETTY_PRINT);
    $jsonFeatures = json_encode($features, JSON_PRETTY_PRINT);
    
    file_put_contents('./cellar/cfg.json', $jsonConfig);
    file_put_contents('./cellar/features.json', $jsonFeatures);

    echo "Setup complete! Configuration has been saved.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Setup Configuration</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 0 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], select { width: 100%; padding: 8px; }
        .checkbox-group { display: flex; gap: 10px; flex-wrap: wrap; }
    </style>
</head>
<body>
    <h1>Setup Configuration</h1>
    <form method="POST">
        <div class="form-group">
            <label for="environment">Environment:</label>
            <select name="environment" id="environment">
                <option value="development">Development</option>
                <option value="production">Production</option>
                <option value="testing">Testing</option>
            </select>
        </div>

        <div class="form-group">
            <label for="name">School Name:</label>
            <input type="text" name="name" id="name" value="playground-highschool" required>
        </div>

        <div class="form-group">
            <label>Grades Offered:</label>
            <div class="checkbox-group">
                <?php for($i = 8; $i <= 12; $i++): ?>
                    <label>
                        <input type="checkbox" name="grades[]" value="<?php echo $i; ?>"
                            <?php echo in_array($i, [8, 9, 11, 12]) ? 'checked' : ''; ?>>
                        Grade <?php echo $i; ?>
                    </label>
                <?php endfor; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="adm_mail">Administrator Email:</label>
            <input type="email" name="adm_mail" id="adm_mail" required>
        </div>

        <div class="form-group">
            <h2>Features</h2>
            <div class="feature-toggle">
                <label>
                    <input type="checkbox" name="feature_campus_map" id="feature_campus_map" onchange="toggleCampusMapOptions()">
                    Enable Campus Map
                </label>
                
                <div id="campus_map_options" style="display: none; margin-left: 20px; margin-top: 10px;">
                    <label>
                        <input type="checkbox" name="campus_map_multiple_buildings">
                        My school has multiple buildings
                    </label>
                    <br>
                    <label>
                        <input type="checkbox" name="campus_map_time_restricted" onchange="toggleTimeRestriction()">
                        Restrict map access hours
                    </label>
                    <div id="time_restriction" style="display: none; margin-top: 10px;">
                        <label>Available from: 
                            <input type="time" name="campus_map_from" value="07:00">
                        </label>
                        <br>
                        <label>Until: 
                            <input type="time" name="campus_map_until" value="18:00">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit">Save Configuration</button>
    </form>

    <script>
        function toggleCampusMapOptions() {
            const checkbox = document.getElementById('feature_campus_map');
            const options = document.getElementById('campus_map_options');
            options.style.display = checkbox.checked ? 'block' : 'none';
        }

        function toggleTimeRestriction() {
            const checkbox = document.querySelector('input[name="campus_map_time_restricted"]');
            const timeInputs = document.getElementById('time_restriction');
            timeInputs.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
</body>
</html>
