<x-app-layout>
    <div class="pagetitle">
        <h1>Courier Details</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Courier</li>
            <li class="breadcrumb-item active">Add Details</li>
          </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Add Courier Details</h5>
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
                <!-- Horizontal Form -->
                <form action="{{ route('courier-add-details') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Trade Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="inputText" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Pricing</label>
                        <div class="col-sm-10">
                            <input type="number" name="price" class="form-control" id="inputText" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-save"></i>
                            Save Details
                        </button>
                    </div>
                </form><!-- End Horizontal Form -->
              </div>
            </div>
          </div>
        </div>
    </section>
</x-app-layout>
