<x-app-layout>
    <div class="pagetitle">
        <h1>Check Point</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Add</li>
            <li class="breadcrumb-item active">Check Point</li>
          </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="alert alert-danger" :errors="$errors" />
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-1"></i>
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <form action="{{route('admin-add-checkpoints')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />

            <input type="hidden" name="lat" id="lat" value="" />
            <input type="hidden" name="lon" id="lon" value="" />
            <div class="row">
                <div class="col-lg-9">
                    <input type="text" id="address-input" name="address_address" class="form-control map-input" required>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary">Add Checkpoint</button>
                </div>
            </div>
        </div>
    </form>
    <div id="address-map-container" style="width:100%;height:400px; " class="mt-2">
        <div style="width: 100%; height: 100%" id="address-map"></div>
    </div>
    <script>
        let latitu = document.getElementById('address-latitude').value;
        let latinput = document.getElementById('lat');

        let longitu = document.getElementById('address-longitude').value;
        let longinput = document.getElementById('lon');
        if(latitu !== 0)
        {
            latinput.value = latitu;
            longinput.value = longitu;
        }

    </script>
</x-app-layout>
