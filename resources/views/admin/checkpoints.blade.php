<x-app-layout>
    <div class="pagetitle">
        <h1>CheckPoints</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Checkpoints</li>
              </ol>
          </nav>
      </div>
      <!-- End Page Title -->
    <section class="section">
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Courrier Checkpoints</h5>
                        <a href="{{ route('add-checkpoints') }}" class="btn btn-primary">
                            Add New
                        </a>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Lat,Lon</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($checkpoints as $point)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $point->name }}</td>
                                        <td>{{ $point->address }}</td>
                                        <td>{{ $point->cordinates }}</td>
                                        <td>{{ $point->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editCheckpoint{{ $point->id }}"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCheckpoint{{ $point->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                        <!-- Edit Category Modal -->
                                            <div class="modal fade" id="editCheckpoint{{ $point->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin-edit-checkpoints') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="point_id" value="{{ $point->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Check Point</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Name:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="name" class="form-control" value="{{ $point->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Address:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="address" class="form-control" value="{{ $point->address }}" required>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $cords = explode (",", $point->cordinates);
                                                                @endphp
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Latitude:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="latitude" class="form-control" value="{{ $cords[0] }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Longitude:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="longitude" class="form-control" value="{{ $cords[1] }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- End Edit Category Modal-->

                                         <!-- Delete Category Modal -->
                                         <div class="modal fade" id="deleteCheckpoint{{ $point->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin-delete-checkpoints') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="point_id" value="{{ $point->id }}" required>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Check Point</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="modal-title">Are you sure you want to pemanently delete {{ $point->name }} from check points?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            <button type="submit" class="btn btn-danger">Yes Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Delete Category Modal-->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Large Modal -->
    {{-- <div class="modal fade" id="addCategory" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin-add-checkpoints') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Check Point</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Mbare Station" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Address:</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" placeholder="123 Good Place" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">User:</label>
                            <div class="col-sm-10">
                                <select name="user_id" class="form-control" value="" required>
                                    <option selected disabled>Select User</option>

                                    @foreach ($users as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Latitude:</label>
                            <div class="col-sm-10">
                                <input type="text" name="latitude" class="form-control" placeholder="-12.645432" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Longitude:</label>
                            <div class="col-sm-10">
                                <input type="text" name="longitude" class="form-control" placeholder="12.645432" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- End Large Modal-->
</x-app-layout>
