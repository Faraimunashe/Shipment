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
                        <h5 class="card-title">Transporters</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                            Add New
                        </button>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Reg Num</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($transporters as $transporter)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $transporter->name }}</td>
                                        <td>{{ $transporter->regnum }}</td>
                                        <td>
                                            @php
                                                $user = \App\Models\User::find($transporter->user_id);
                                                if(is_null($user))
                                                {
                                                    echo "not assigned";
                                                }else{
                                                    echo $user->name;
                                                }
                                            @endphp
                                        </td>
                                        <td>{{ $transporter->type }}</td>
                                        <td>{{ $transporter->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editTransporter{{ $transporter->id }}"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTransporter{{ $transporter->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                        <!-- Edit Category Modal -->
                                            <div class="modal fade" id="editTransporter{{ $transporter->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin-edit-transporters') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="transporter_id" value="{{ $transporter->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Transporter</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Name:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="name" class="form-control" value="{{ $transporter->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Reg Num:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="regnum" class="form-control" value="{{ $transporter->regnum }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">User:</label>
                                                                    <div class="col-sm-10">
                                                                        <select name="user_id" class="form-control" value="" required>
                                                                            <option selected disabled>
                                                                                @php
                                                                                    if(is_null($user))
                                                                                    {
                                                                                        echo "not assigned";
                                                                                    }else{
                                                                                        echo $user->name;
                                                                                    }
                                                                                @endphp
                                                                            </option>
                                                                            @foreach ($users as $item)
                                                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Type:</label>
                                                                    <div class="col-sm-10">
                                                                        <select name="type" class="form-control" required>
                                                                            <option selected disabled>Select Type</option>
                                                                            <option value="road">Road</option>
                                                                            <option value="air" disabled>Air</option>
                                                                            <option value="rail" disabled>Rail</option>
                                                                        </select>
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
                                         <div class="modal fade" id="deleteTransporter{{ $transporter->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin-delete-transporters') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="transporter_id" value="{{ $transporter->id }}" required>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Transporter</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="modal-title">Are you sure you want to pemanently delete {{ $transporter->name }} from transporter?</h6>
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
    <div class="modal fade" id="addCategory" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin-add-transporters') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Transporter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Mazda T35" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Reg Num:</label>
                            <div class="col-sm-10">
                                <input type="text" name="regnum" class="form-control" placeholder="ACB 0000" required>
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
                            <label for="inputText" class="col-sm-2 col-form-label">Type:</label>
                            <div class="col-sm-10">
                                <select name="type" class="form-control" required>
                                    <option selected disabled>Select Type</option>
                                    <option value="road">Road</option>
                                    <option value="air" disabled>Air</option>
                                    <option value="rail" disabled>Rail</option>
                                </select>
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
    </div>
    <!-- End Large Modal-->
</x-app-layout>
