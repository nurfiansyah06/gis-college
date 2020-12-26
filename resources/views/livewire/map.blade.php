<div class="">
    <style>
        .legend {
            width: 300px;
            position: absolute;
            z-index: 10;
            margin-top: 330px;
            margin-left: 20px;
        }

        .card {
            border-radius: 20px;
        }

        .tambah-lokasi {
            position: absolute;
            z-index: 10;
            margin-top: 20px;
            margin-left: 20px;
        }

        .tambah-button {
            border-radius: 14px;
            width: 200px;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
    <div class="tambah-lokasi">
        <a href="{{ url('/addlocation') }}" class="btn btn-success tambah-button">Tambah Lokasi</a>
    </div>
    <div class="legend">
        <div class="card">
            <div class="card-body">
                <h5 style="font-weight: bold">Legenda Peta Banjir</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold">Kategori</td>
                            <td style="font-weight: bold">Rasio</td>
                            <td style="font-weight: bold">Status</td>
                        </tr>
                        <tr>
                            <td>Siaga 1</td>
                            <td>Lebih dari 150 m</td>
                            <td><i class="fa fa-square" style="color: #CC2A41"></i></td>
                        </tr>
                        <tr>
                            <td>Siaga 2</td>
                            <td>71 - 150 m</td>
                            <td><i class="fa fa-square" style="color: #FF8300"></i></td>
                        </tr>
                        <tr>
                            <td>Siaga 3</td>
                            <td>10 - 70 m</td>
                            <td><i class="fa fa-square" style="color: #FFFF00"></i></td>
                        </tr>
                        <tr>
                            <td>Siaga 4</td>
                            <td>Kurang dari 10 m (Hati-hati)</td>
                            <td><i class="fa fa-square" style="color: #A0A9F7"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div wire:ignore id="map" style='width: 100%; height: 94vh;margin-top:-20px' ></div>

    <script>
        document.addEventListener('livewire:load',  ()  => {

        const defaultLocation = [110.4229055130026, -6.991840834967931];
        const coordinateInfo = document.getElementById('info');

        mapboxgl.accessToken = "{{env('MAPBOX_KEY')}}";
        let map = new mapboxgl.Map({
            container: "map",
            center: defaultLocation,
            zoom: 12.15,
            // style: "mapbox://styles/mapbox/streets-v8"
        });

        map.addControl(
            new MapboxGeocoder({
            accessToken: "{{env('MAPBOX_KEY')}}",
            mapboxgl: mapboxgl
            })
        );

        map.addControl(new mapboxgl.NavigationControl());

        const loadGeoJSON = (geojson) => {

            geojson.features.forEach(function (marker) {
                const {geometry, properties} = marker
                const {iconSize, locationId, title, image, description, height} = properties

                let el = document.createElement('div');
                el.className = 'marker' + locationId;
                el.id = locationId;
                if (height > 150) {
                    el.style.backgroundImage = 'url({{asset("red.png")}})';
                } else if (height > 71) {
                    el.style.backgroundImage = 'url({{asset("orange.png")}})';
                } else if (height > 10) {
                    el.style.backgroundImage = 'url({{asset("yellow.png")}})';
                } else {
                    el.style.backgroundImage = 'url({{asset("purple.png")}})';
                }

                el.style.color = '#FFFFF';
                el.style.backgroundSize = 'cover';
                el.style.width = iconSize[0] + 'px';
                el.style.height = iconSize[1] + 'px';

                const pictureLocation = '{{asset("/storage/images")}}' + '/' + image

                const content = `
                <div style="overflow-y: scroll; height:200px;width:100%;">
                    <table class="table table-borderless table-sm mt-1">
                         <tbody>
                            <tr>
                                <td>Nama Lokasi</td>
                                <td>${title}</td>
                            </tr>
                            <tr>
                                <td>Foto Banjir</td>
                                <td><img src="${pictureLocation}" loading="lazy" class="img-fluid"/></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>${description}</td>
                            </tr>
                            <tr>
                                <td>Ketinggian</td>
                                <td>${height} Meter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                `;

                let popup = new mapboxgl.Popup({ offset: 25 }).setHTML(content).setMaxWidth("400px")
;

                el.addEventListener('click', (e) => {
                    const locationId = e.toElement.id
                    @this.findLocationById(locationId)
                });

                new mapboxgl.Marker(el)
                .setLngLat(geometry.coordinates)
                .setPopup(popup)
                .addTo(map);
            });
        }

        loadGeoJSON({!! $geoJson !!})

        window.addEventListener('locationAdded', (e) => {
            swal({
                title: "Location Added!",
                text: "Your location has been save sucessfully!",
                icon: "success",
                button: "Ok",
            }).then((value) => {
                loadGeoJSON(JSON.parse(e.detail))
            });
        })

        window.addEventListener('deleteLocation', (e) => {
            console.log(e.detail);
            swal({
                title: "Location Delete!",
                text: "Your location deleted sucessfully!",
                icon: "success",
                button: "Ok",
            }).then((value) => {
               $('.marker' + e.detail).remove();
               $('.mapboxgl-popup').remove();
            });
        })

        window.addEventListener('updateLocation', (e) => {
            console.log(e.detail);
            swal({
                title: "Location Update!",
                text: "Your location updated sucessfully!",
                icon: "success",
                button: "Ok",
            }).then((value) => {
               loadGeoJSON(JSON.parse(e.detail))
               $('.mapboxgl-popup').remove();
            });
        })

        //light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
        const style = "streets-v11"
        map.setStyle(`mapbox://styles/mapbox/${style}`);

        const getLongLatByMarker = () => {
            const lngLat = marker.getLngLat();
            return 'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;
        }

        map.on('click', (e) => {
            if(@this.isEdit){
                return
            }else{
                coordinateInfo.innerHTML = JSON.stringify(e.point) + '<br />' + JSON.stringify(e.lngLat.wrap());
                @this.long = e.lngLat.lng;
                @this.lat = e.lngLat.lat;
            }
        });
    })
    </script>
</div>
