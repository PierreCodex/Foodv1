<?php
include('clientPartials/clientHeader.php');

?>

<!-- Menu Top Section -->


<!-- Sección principal del menú -->
<section class="container section menuPage">
    <div class="secContent">
        <div class="sectionIntro">
            <h1 class="secTitle">Optimización de Rutas de Reparto</h1>
            <p class="subTitle">Calcula el tiempo estimado para llegar a Cevichería Morales desde tu ubicación actual.</p>
            <img src="./Assests/titleDesign.png" alt="Design Image">
        </div>
        <!-- Agregar contenedor para el mapa -->

        <div class="optionMenu flex">


            <div id="map"></div>
            <div class="control-panel">
            <h3>Rutas Cevichería Morales</h3>
             <p>Haz clic en el botón para obtener tu ubicación y calcular el tiempo hasta el restaurante.</p>
                <button id="get-user-location">Obtener mi Ubicación</button>
                <div id="points-list"></div>
              
                <button id="clear-points">Limpiar Puntos</button>
                <div id="route-info"></div>
            </div>
        </div>

    </div>
</section>


<script>
// Agrega tu token de Mapbox
mapboxgl.accessToken = 'pk.eyJ1IjoicGllcnJlY29kZXgiLCJhIjoiY21ieWYyMzFmMW14ZzJsb2F5NGk5NGFmbyJ9.NZ4UTnOrt4Dc5hLOSlE7xA';

// Coordenadas del punto fijo (Cevichería Morales)
const fixedOrigin = [-80.69933701649022, -4.9054453579127255];  // Coordenadas de la Cevichería Morales

// Inicializar el mapa
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: fixedOrigin,  // Centrar en la Cevichería Morales (origen)
    zoom: 14
});

// Crear el marcador para el origen fijo (Cevichería Morales)
const originMarker = new mapboxgl.Marker({ color: 'red' })
    .setLngLat(fixedOrigin)
    .addTo(map);

// Variables para almacenar el destino
let destination = null; // Este será el destino que se actualizará al hacer clic

// Función para obtener la ubicación del usuario
function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userCoordinates = [position.coords.longitude, position.coords.latitude];

            // Establecer la ubicación del usuario como destino
            if (destination) {
                destination.remove();
            }

            // Agregar un marcador para la ubicación del usuario
            destination = new mapboxgl.Marker({ color: 'blue' })
                .setLngLat(userCoordinates)
                .addTo(map);

            // Calcular la ruta entre la Cevichería Morales (fijo) y la ubicación del usuario
            calculateRoute(fixedOrigin, userCoordinates);
        }, error => {
            console.error('Error al obtener la ubicación del usuario:', error);
            alert('No se pudo obtener la ubicación del usuario. Asegúrate de que la geolocalización esté habilitada en tu navegador.');
        });
    } else {
        alert('Geolocalización no soportada por este navegador.');
    }
}

// Función para calcular la ruta entre la Cevichería Morales (fijo) y el destino
async function calculateRoute(origin, destination) {
    const coordinates = [origin.join(','), destination.join(',')];

    const baseUrl = `https://api.mapbox.com/directions/v5/mapbox/driving-traffic/${coordinates.join(';')}`;

    const params = new URLSearchParams({
        alternatives: 'true',
        geometries: 'geojson',
        annotations: 'distance,duration', // Incluir distancia y duración
        overview: 'full',
        steps: 'true',
        access_token: mapboxgl.accessToken
    });

    const url = `${baseUrl}?${params.toString()}`;
    console.log("URL de solicitud: " + url);

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.code !== 'Ok') {
            console.error("Error de la API:", data.message);
            alert(`Error de la API: ${data.message}`);
            return;
        }

        displayRoute(data); // Mostrar la ruta en el mapa
        displayRouteInfo(data); // Mostrar información de la ruta
    } catch (error) {
        console.error('Error al calcular la ruta:', error);
        alert('Hubo un error al calcular la ruta. Verifica la consola para más detalles.');
    }
}

// Función para mostrar la ruta en el mapa
function displayRoute(routeData) {
    if (map.getSource('route')) {
        map.removeLayer('route-layer');
        map.removeSource('route');
    }

    map.addSource('route', {
        type: 'geojson',
        data: {
            type: 'Feature',
            properties: {},
            geometry: routeData.routes[0].geometry
        }
    });

    map.addLayer({
        id: 'route-layer',
        type: 'line',
        source: 'route',
        layout: {
            'line-join': 'round',
            'line-cap': 'round'
        },
        paint: {
            'line-color': '#7525be',
            'line-width': 5,
            'line-opacity': 0.75
        }
    });

    const coordinates = routeData.routes[0].geometry.coordinates;
    const bounds = coordinates.reduce((bounds, coord) => {
        return bounds.extend(coord);
    }, new mapboxgl.LngLatBounds(coordinates[0], coordinates[0]));

    map.fitBounds(bounds, {
        padding: 50
    });
}

// Función para mostrar la información de la ruta
function displayRouteInfo(routeData) {
    const route = routeData.routes[0];
    const distance = (route.distance / 1000).toFixed(2); // Convertir a km
    const duration = Math.floor(route.duration / 60); // Convertir a minutos    

    const routeInfo = document.getElementById('route-info');
    routeInfo.innerHTML = `
        <h4>Información de la Ruta</h4><br>
        <p>Distancia total: ${distance} km</p>
        <p>Tiempo estimado: ${duration} minutos</p>
    `;
}

// Función para limpiar todos los puntos
document.getElementById('clear-points').addEventListener('click', () => {
    // Eliminar el marcador de destino (no el origen)
    if (destination) {
        destination.remove();
    }

    // Eliminar la ruta del mapa
    if (map.getSource('route')) {
        map.removeLayer('route-layer');
        map.removeSource('route');
    }

    // Limpiar información de la ruta
    document.getElementById('route-info').innerHTML = '';
});

// Botón para obtener la ubicación del usuario
document.getElementById('get-user-location').addEventListener('click', () => {
    getUserLocation();  // Obtener la ubicación del usuario y calcular la ruta
});

</script>


<!-- Menu Top Section Ends -->

<?php
include('clientPartials/clientFooter.php');
?>