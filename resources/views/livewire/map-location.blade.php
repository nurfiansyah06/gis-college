<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        MAP
                    </div>
                    <div class="card-body">
                        <div wire:ignore id='map' style='width: 100%; height: 75vh;'></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Form
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Longtitude">Longtitude</label>
                                    <input wire:model="long" type="text" name="" id="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Longtitude">Latitude</label>
                                    <input wire:model="lat" type="text" name="" id="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('livewire:load', () => {
            const defaultLocation = [110.4229055130026, -6.991840834967931];

            mapboxgl.accessToken = '{{ env('MAPBOX_KEY') }}';
            var map = new mapboxgl.Map({
                container: 'map',
                center : defaultLocation,
                zoom : 11.15,
                // style: 'mapbox://styles/mapbox/streets-v11'
            });

            // var marker = new mapboxgl.Marker() // initialize a new marker
            // .setLngLat([110.4229055130026, -6.991840834967931]) // Marker [lng, lat] coordinates
            // .addTo(map);

            const geoJson = {
                "type": "FeatureCollection",
                "features": [
                    {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                        "106.73830754205",
                        "-6.2922403995615"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Mantap",
                        "iconSize": [
                        50,
                        50
                        ],
                        "locationId": 30,
                        "title": "Hello new",
                        "image": "1a1eb1e4106fff0cc3467873f0f39cab.jpeg",
                        "description": "Mantap"
                    }
                    },
                    {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                        "106.68681595869",
                        "-6.3292244652013"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "oke mantap Edit",
                        "iconSize": [
                        50,
                        50
                        ],
                        "locationId": 29,
                        "title": "Rumah saya Edit",
                        "image": "0ea59991df2cb96b4df6e32307ea20ff.png",
                        "description": "oke mantap Edit"
                    }
                    },
                    {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                        "106.62490035406",
                        "-6.3266855038639"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Update Baru",
                        "iconSize": [
                        50,
                        50
                        ],
                        "locationId": 22,
                        "title": "Update Baru Gambar",
                        "image": "d09444b68d8b72daa324f97c999c2301.jpeg",
                        "description": "Update Baru"
                    }
                    },
                    {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                        "106.72391468711",
                        "-6.3934163494543"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                        "iconSize": [
                        50,
                        50
                        ],
                        "locationId": 19,
                        "title": "awdwad",
                        "image": "f0b88ffd980a764b9fca60d853b300ff.png",
                        "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
                    }
                    },
                    {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                        "106.67224158205",
                        "-6.3884963990263"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                        "iconSize": [
                        50,
                        50
                        ],
                        "locationId": 18,
                        "title": "adwawd",
                        "image": "4c35cb1b76af09e6205f94024e093fe6.jpeg",
                        "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
                    }
                    },
                    {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                        "106.74495523289",
                        "-6.3642034511073"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "awdwad",
                        "iconSize": [
                        50,
                        50
                        ],
                        "locationId": 12,
                        "title": "adawd",
                        "image": "7c8c949fd0499eb50cb33787d680778c.jpeg",
                        "description": "awdwad"
                        }
                    }
                ]
            }

            const loadLocations = () => {
                geoJson.features.forEach((location) => {
                    const{geometry, properties} = location
                    const {iconSize, locationId, title, image, description} = properties

                    let markerElement = document.createElement('div')
                    markerElement.className = 'marker' + locationId
                    markerElement.id = locationId
                    markerElement.style.backgroundImage = 'asset(blue.png)'
                    markerElement.style.backgroundSize = 'cover'
                    markerElement.style.width = '50px'
                    markerElement.style.height = '50px'

                    new mapboxgl.Marker(markerElement)
                    .setLngLat(geometry.coordinates)
                    .addTo(map)

                });
            }

            loadLocations();
            var geocoder = new MapboxGeocoder({ // Initialize the geocoder
                accessToken: mapboxgl.accessToken, // Set the access token
                placeholder: 'Pencarian Lokasi Kota Semarang',
                localGeocoder:  console.log(coordinatesGeocoder),
                // bbox : [110.40878890731341,-7.1369851555135995,110.40701496412919,6.9515403289657485],
                proximity : {
                    longtitude : 110.4229055130026,
                    latitude : -6.991840834967931
                },
                mapboxgl: mapboxgl, // Set the mapbox-gl instance
                marker: false, // Do not use the default marker style
            });

            // Add the geocoder to the map
            map.addControl(geocoder);
                // console.log(geocoder);

            var coordinatesGeocoder = function (query) {
                // match anything which looks like a decimal degrees coordinate pair
                var matches = query.match(
                    /^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
                );
                if (!matches) {
                    return null;
                }

                    function coordinateFeature(lng, lat) {
                    return {
                        center: [lng, lat],
                        geometry: {
                        type: 'Point',
                        coordinates: [lng, lat]
                    },
                        place_name: 'Lat: ' + lat + ' Lng: ' + lng,
                        place_type: ['coordinate'],
                        properties: {},
                        type: 'Feature'
                        };
                    }

                    var coord1 = Number(matches[1]);
                    var coord2 = Number(matches[2]);
                    var geocodes = [];

                    if (coord1 < -90 || coord1 > 90) {
                    // must be lng, lat
                        geocodes.push(coordinateFeature(coord1, coord2));
                    }

                    if (coord2 < -90 || coord2 > 90) {
                    // must be lat, lng
                        geocodes.push(coordinateFeature(coord2, coord1));
                    }

                    if (geocodes.length === 0) {
                    // else could be either lng, lat or lat, lng
                        geocodes.push(coordinateFeature(coord1, coord2));
                        geocodes.push(coordinateFeature(coord2, coord1));
                    }

                };


            // After the map style has loaded on the page,
            // add a source layer and default styling for a single point
            map.on('load', function() {
                map.addSource('single-point', {
                    type: 'geojson',
                    data: {
                    type: 'FeatureCollection',
                    features: []
                    }
                });

                map.addLayer({
                    id: 'point',
                    source: 'single-point',
                    type: 'circle',
                    paint: {
                    'circle-radius': 10,
                    'circle-color': '#448ee4'
                    }
                });

                // Listen for the `result` event from the Geocoder
                // `result` event is triggered when a user makes a selection
                //  Add a marker at the result's coordinates
                geocoder.on('result', function(e) {
                    map.getSource('single-point').setData(e.result.geometry);
                });
            });
            const style = "outdoors-v11"
            map.setStyle(`mapbox://styles/mapbox/${style}`)

            map.addControl(new mapboxgl.NavigationControl())

            map.on('click', (e) => {
                const longtitude = e.lngLat.lng
                const latitude = e.lngLat.lat

                @this.long = longtitude;
                @this.lat = latitude;
            })
        })
    </script>
@endpush
