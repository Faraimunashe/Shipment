<x-app-layout>
        <div class="pagetitle">
            <h1>Products</h1>
              <nav>
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                      <li class="breadcrumb-item active">Products</li>
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
                            <h5 class="card-title">Products</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                                Add New
                            </button>
                            <!-- Table with stripped rows -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">
                                                @php
                                                    $count++;
                                                    echo $count;
                                                @endphp
                                            </th>
                                            <td>
                                                @php
                                                    $category = \App\Models\Category::where('id', $product->category_id)->first();
                                                    echo $category->name;
                                                @endphp
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->slug }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editproduct{{ $product->id }}"><i class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteproduct{{ $product->id }}"><i class="bi bi-trash"></i></button>
                                            </td>
                                            <!-- Edit product Modal -->
                                                <div class="modal fade" id="editproduct{{ $product->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin-edit-categories') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $product->id }}" required>
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit product</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row mb-3">
                                                                        <label for="inputText" class="col-sm-2 col-form-label">Name:</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputText" class="col-sm-2 col-form-label">Slug:</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="slug" class="form-control" value="{{ $product->slug }}" required>
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
                                            <!-- End Edit product Modal-->

                                             <!-- Delete product Modal -->
                                             <div class="modal fade" id="deleteproduct{{ $product->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin-delete-products') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h6 class="modal-title">Are you sure you want to pemanently delete {{ $product->name }} from categories?</h6>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-danger">Yes Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Delete product Modal-->
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
        <div class="modal fade" id="addProduct" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin-add-products') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add New product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Category:</label>
                                <div class="col-sm-10">
                                    <select name="category_id" class="form-control" required>
                                        <option selected disabled>Select Category</option>
                                        @foreach (\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Slug:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="slug" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Price:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="price" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Image:</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class="form-control" required>
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
        <!-- End Large Modal-->
</x-app-layout>
