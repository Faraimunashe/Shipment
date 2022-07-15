<x-app-layout>
    <div class="pagetitle">
        <h1>Location</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Courrier</li>
            <li class="breadcrumb-item active">Location</li>
          </ol>
        </nav>
    </div>
        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="text" id="address-input" name="address_address" class="form-control map-input">
            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
        </div>
        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
</x-app-layout>
