<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Location;

class MapLocation extends Component
{
    use WithFileUploads;

    public $long, $lat,$locationId ,$title, $description, $image;
    public $geoJson;
    public $imageUrl;
    public $isEdit = false;

    private function loadLocations() {
        $locations = Location::orderBy('created_at','desc')->get();

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$location->long, $location->lat],
                    'type' => 'Point'
                ],
                'properties' => [
                    'locationId'    => $location->id,
                    'title'         => $location->title,
                    'image'         => $location->image,
                    'address'       => $location->address,
                    'height'        => $location->height,
                    'description'   => $location->description
                ]
            ];
        }

        $geoLocation = [
            'type'      => 'FeatureLocation',
            'features'  => $customLocations
        ];

        $geoJson = collect($geoLocation)->toJson();
        $this->geoJson = $geoJson;
    }

    public function saveLocation()
    {
        $this->validate([
            'long' => 'required',
            'lat' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|max:2048|required'
            // 'long' => 'required'
        ]);

        $imageName = md5($this->image.microtime()).'.'. $this->image->extension();

        Storage::putFileAs(
            'public/images', $this->image, $imageName
        );

        Location::create([
            'long' => $this->long,
            'lat' => $this->lat,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imageName
        ]);

        $this->clearForm();
        $this->loadLocations();
        $this->dispatchBrowserEvent('locationAdded', $this->geoJson);

    }

    public function findLocationById($id)
    {
        $location = Location::findOrFail($id);

        $this->locationId       = $id;
        $this->long             = $location->long;
        $this->lat              = $location->lat;
        $this->title            = $location->title;
        $this->description      = $location->description;
        $this->imageUrl         = $location->image;
        $this->isEdit           = true;
    }

    public function updateLocation()
    {
        $this->validate([
            'long' => 'required',
            'lat' => 'required',
            'title' => 'required',
            'description' => 'required',
            // 'long' => 'required'
        ]);

        $location = Location::findOrFail($this->locationId);
        if ($this->image) {
            $imageName = md5($this->image.microtime()).'.'. $this->image->extension();

            Storage::putFileAs(
                'public/images', $this->image, $imageName
            );

            $updateData = [
                'title'         => $this->title,
                'description'   => $this->description,
                'image'         => $imageName,
            ];
        }
        else {
            $updateData = [
                'title'         => $this->title,
                'description'   => $this->description,
            ];
        }

        $location->update($updateData);
        $this->clearForm();
        $this->loadLocations();
        $this->dispatchBrowserEvent('locationUpdated', $this->geoJson);
    }

    private function clearForm() {
        $this->long = '';
        $this->lat = '';
        $this->title = '';
        $this->description = '';
        $this->image = '';
    }

    public function render()
    {
        $this->loadLocations();
        return view('livewire.map-location');
    }
}
