console.log('Loading toolbar.js');
const mapContainer = document.getElementById('map-container');
const lowDetail = document.getElementById('lowDetail');
const mediumDetail = document.getElementById('mediumDetail');
const highDetail = document.getElementById('highDetail');

// Debug check if elements exist
console.log('Map container:', mapContainer);
console.log('Low detail:', lowDetail);
console.log('Medium detail:', mediumDetail);
console.log('High detail:', highDetail);

let currentZoom = 1;
const zoomLevels = {
    low: { min: 1, max: 1.5 },
    medium: { min: 1.5, max: 2.5 },
    high: { min: 2.5, max: 4 }
};

function updateDetailLevel() {
    console.log('Updating detail level. Current zoom:', currentZoom);
    
    // Hide all images first
    lowDetail.classList.remove('visible');
    mediumDetail.classList.remove('visible');
    highDetail.classList.remove('visible');

    // Show appropriate image based on zoom level
    if (currentZoom >= zoomLevels.high.min) {
        console.log('Showing high detail');
        highDetail.classList.add('visible');
    } else if (currentZoom >= zoomLevels.medium.min) {
        console.log('Showing medium detail');
        mediumDetail.classList.add('visible');
    } else {
        console.log('Showing low detail');
        lowDetail.classList.add('visible');
    }
}

function setZoom(zoom) {
    const oldZoom = currentZoom;
    currentZoom = Math.max(zoomLevels.low.min, Math.min(zoom, zoomLevels.high.max));
    console.log('Setting zoom to:', currentZoom);
    
    // Get scroll position before zoom
    const scrollXPercent = mapContainer.scrollLeft / mapContainer.scrollWidth;
    const scrollYPercent = mapContainer.scrollTop / mapContainer.scrollHeight;
    
    // Apply zoom to the image-wrapper
    const wrapper = mapContainer.querySelector('.image-wrapper');
    if (wrapper) {
        wrapper.style.transform = `scale(${currentZoom})`;
        console.log('Applied transform:', wrapper.style.transform);
    } else {
        console.error('Image wrapper not found!');
    }
    
    updateDetailLevel();
    
    // Restore scroll position after zoom
    requestAnimationFrame(() => {
        mapContainer.scrollLeft = scrollXPercent * mapContainer.scrollWidth;
        mapContainer.scrollTop = scrollYPercent * mapContainer.scrollHeight;
    });
}

// Zoom button functionality
document.getElementById('zoomIn').addEventListener('click', () => {
    console.log('Zoom in clicked. Current zoom:', currentZoom);
    setZoom(currentZoom + 0.5);
});

document.getElementById('zoomOut').addEventListener('click', () => {
    console.log('Zoom out clicked. Current zoom:', currentZoom);
    setZoom(currentZoom - 0.5);
});

// Add wheel zoom support
mapContainer.addEventListener('wheel', (e) => {
    e.preventDefault();
    const delta = e.deltaY > 0 ? -0.1 : 0.1;
    setZoom(currentZoom + delta);
});

// Initialize
window.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing map');
    // Make sure the wrapper exists
    const wrapper = mapContainer.querySelector('.image-wrapper');
    if (!wrapper) {
        console.error('Image wrapper not found during initialization!');
        return;
    }
    wrapper.style.transform = `scale(${currentZoom})`;
    lowDetail.classList.add('visible');
    updateDetailLevel();
});

// Pan functionality
let isDragging = false;
let startX, startY;
let scrollLeft, scrollTop;

// Set default cursor
mapContainer.style.cursor = 'grab';

mapContainer.addEventListener('mousedown', (e) => {
    isDragging = true;
    mapContainer.style.cursor = 'grabbing';
    
    // Get the initial mouse position
    startX = e.pageX;
    startY = e.pageY;
    
    // Get the current scroll position
    scrollLeft = mapContainer.scrollLeft;
    scrollTop = mapContainer.scrollTop;
});

mapContainer.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    
    e.preventDefault();
    
    // Calculate the distance moved
    const moveX = e.pageX - startX;
    const moveY = e.pageY - startY;
    
    // Update scroll position
    mapContainer.scrollLeft = scrollLeft - moveX;
    mapContainer.scrollTop = scrollTop - moveY;
});

document.addEventListener('mouseup', () => {
    isDragging = false;
    mapContainer.style.cursor = 'grab';
});

mapContainer.addEventListener('mouseleave', () => {
    isDragging = false;
    mapContainer.style.cursor = 'grab';
});