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


            const loadLocations = (geoJson) => {
                geoJson.features.forEach((location) => {
                    const {geometry, properties} = location
                    const {iconSize, locationId, title, image, address, height, description} = properties

                    let markerElement = document.createElement('div')
                    markerElement.className = 'marker' + locationId
                    markerElement.id = locationId

                    if (height < 50) {
                        markerElement.style.backgroundImage = 'url(https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png)'
                    } else {
                        markerElement.style.backgroundImage = 'url(https://image.flaticon.com/icons/png/512/37/37134.png)'
                    }
                    markerElement.style.backgroundSize = 'cover'
                    markerElement.style.width = '30px'
                    markerElement.style.height = '30px'

                    const content = `
                        <div style="overflow-y,auto;max-height:400px,width:100%">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Judul</td>
                                        <td>${title}</td>
                                    </tr>
                                    <tr>
                                        <td>Gambar</td>
                                        <td><img src="${image}" class="img-fluid" loading="lazy"></td>
                                    </tr>
                                    <tr>
                                        <td>Tinggi Banjir</td>
                                        <td>${height}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>${address}</td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>${description}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `

                    const popUp = new mapboxgl.Popup ({
                        offset:25
                    }).setHTML(content).setMaxWidth("400px")

                    new mapboxgl.Marker(markerElement)
                    .setLngLat(geometry.coordinates)
                    .setPopup(popUp)
                    .addTo(map)

                });
            }

            loadLocations({!! $geoJson !!});
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
