<!DOCTYPE html>
<html>
<head>
    <title>Map Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #map {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }
        #map-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: auto;
            transform-origin: top left;
            cursor: default;
        }
        .image-wrapper {
            position: relative;
            width: 200%;
            height: 200%;
            min-width: 2000px;
            min-height: 2000px;
        }
        .map-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            object-fit: contain;
        }
        .map-image.visible {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div id="map">
        <?php include './toolbar.php'; ?>
        <div id="map-container">
            <div class="image-wrapper">
                <img src="img/low-detail.jpg" class="map-image" id="lowDetail" alt="Low detail map">
                <img src="img/medium-detail.jpg" class="map-image" id="mediumDetail" alt="Medium detail map">
                <img src="img/high-detail.jpg" class="map-image" id="highDetail" alt="High detail map">
            </div>
        </div>
    </div>
    <script src="toolbar.js"></script>
</body>
</html> 