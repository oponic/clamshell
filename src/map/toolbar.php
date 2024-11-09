<div class="map-toolbar">
    <div class="toolbar-container">
        <button class="toolbar-btn" id="zoomIn" title="Zoom In">
            <i class="fas fa-plus"></i>
        </button>
        <button class="toolbar-btn" id="zoomOut" title="Zoom Out">
            <i class="fas fa-minus"></i>
        </button>
        <!-- Add more toolbar buttons as needed -->
    </div>
</div>

<style>
.map-toolbar {
    position: absolute;
    top: 10px;
    left: 10px;
    background: white;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    z-index: 1000;
}

.toolbar-container {
    padding: 5px;
}

.toolbar-btn {
    display: block;
    width: 32px;
    height: 32px;
    margin: 5px;
    border: none;
    background: white;
    cursor: pointer;
    border-radius: 4px;
}

.toolbar-btn:hover {
    background: #f0f0f0;
}

.toolbar-btn.active {
    background: #e0e0e0;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

#map-container {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: auto;
    cursor: default;
}

.image-wrapper {
    position: relative;
    width: 200%;
    height: 200%;
    min-width: 2000px;
    min-height: 2000px;
    transform-origin: 0 0;
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

#map {
    position: relative;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
}

img {
    -webkit-user-drag: none;
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
    user-drag: none;
}
</style> 