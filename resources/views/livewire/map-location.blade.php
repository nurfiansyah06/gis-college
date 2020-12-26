
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">
                <div class="text-dark">
                   <div class="d-flex justify-content-between align-items-center">
                       <h1>Tambah Lokasi Banjir</h1>
                   </div>
                </div>
                <div class="" style="">
                    <form @if($isEdit)
                        wire:submit.prevent="update"
                        @else
                        wire:submit.prevent="store"
                        @endif
                    >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div wire:ignore id="map" style='width: 100%; height: 50vh;' ></div>
                                    @if($isEdit)
                                        <button wire:click="clearForm" class="btn btn-success active mt-2">Tambah Lokasi</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="text-dark">Longtitude</label>
                                    <input type="text" wire:model="long" class="form-control dark-input"
                                        {{$isEdit ? 'disabled' : null}}
                                    />
                                     @error('long') <small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="text-dark">Latitude</label>
                                    <input type="text" wire:model="lat" class="form-control dark-input"
                                        {{$isEdit ? 'disabled' : null}}
                                    />
                                     @error('lat') <small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-dark">Nama Lokasi</label>
                            <input type="text" wire:model="title" class="form-control dark-input"  placeholder="Nama Lokasi.."/>
                             @error('title') <small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label class="text-dark">Ketinggian Meter</label>
                            <input type="text" wire:model="height" class="form-control dark-input" placeholder="Ketinggian.." />
                             @error('height') <small class="text-danger">{{$message}}</small>@enderror
                             <label for="">Ketik hanya angka. Cth : 150 <span style="color: red">*</span></label>
                        </div>
                        <div class="form-group">
                            <label class="text-dark">Deskripsi Ketinggian</label>
                            <textarea wire:model="description" class="form-control dark-input" placeholder="Deskripsi.."></textarea>
                             @error('description') <small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label class="text-dark">Foto</label>
                                <div class="custom-file dark-input">
                                <input wire:model="image" type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label dark-input" for="customFile">Choose file</label>
                                </div>
                            @error('image') <small class="text-danger">{{$message}}</small>@enderror
                            @if($image)
                                <img src="{{$image->temporaryUrl()}}" class="img-fluid" alt="Preview Image">
                            @endif
                            @if($imageUrl && !$image)
                                <img src="{{asset('/storage/images/'.$imageUrl)}}" class="img-fluid" alt="Preview Image">
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn active btn-{{$isEdit ? 'success ' : 'primary'}} btn-block" style="width: 200px;border-radius:14px;font-weight:bold;color:#FFFF">{{$isEdit ? 'Update Location' : 'Submit Location'}}</button>
                            @if($isEdit)
                            <button wire:click="deleteLocationById" type="button" class="btn btn-danger active btn-block" style="width: 200px;border-radius:14px;font-weight:bold">Delete Location</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins';
    }
    .swal-footer {
        text-align: center;
    }
</style>

<div id="info" style="display:none"></div>



@push('script')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
   document.addEventListener('livewire:load',  ()  => {

            swal({
                title: "Perhatian!",
                text: "Klik lokasi pada peta untuk mendapatkan koordinat",
                icon: "warning",
                buttons: "OK",
            })

        const defaultLocation = [110.4229055130026, -6.991840834967931];
        const coordinateInfo = document.getElementById('info');

        mapboxgl.accessToken = "{{env('MAPBOX_KEY')}}";
        let map = new mapboxgl.Map({
            container: "map",
            center: defaultLocation,
            zoom: 11.15,
            style: "mapbox://styles/mapbox/streets-v11"
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
                @guest
                    el.style.display = 'none'
                @else
                if (height > 150) {
                    el.style.backgroundImage = 'url({{asset("red.png")}})';
                } else if (height > 71) {
                    el.style.backgroundImage = 'url({{asset("orange.png")}})';
                } else if (height > 10) {
                    el.style.backgroundImage = 'url({{asset("yellow.png")}})';
                } else {
                    el.style.backgroundImage = 'url({{asset("purple.png")}})';
                }
                @endguest
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
                title: "Sukses!",
                text: "Lokasi Berhasil Ditambah",
                icon: "success",
                buttons: ["Tambah Lokasi","Lihat Semua Lokasi"],

            }).then((value) => {
                if (value) {
                    window.location.href = "/map"
                }
            });
        })

        window.addEventListener('deleteLocation', (e) => {
            console.log(e.detail);
            swal({
                title: "Sukses",
                text: "Lokasi Berhasil Dihapus!",
                icon: "success",
                button: "OK",
            }).then((value) => {
               $('.marker' + e.detail).remove();
               $('.mapboxgl-popup').remove();
            });
        })

        window.addEventListener('updateLocation', (e) => {
            console.log(e.detail);
            swal({
                title: "Sukses",
                text: "Lokasi Berhasil Diupdate!",
                icon: "success",
                button: "OK",
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
@endpush
