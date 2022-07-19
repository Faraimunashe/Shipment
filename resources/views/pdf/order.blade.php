<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table table-striped">
        <thead>
          <th>ID</th>
          <th>Full Name</th>
          <th>Address</th>
          <th>City</th>
          <th>Zip Code</th>
          <th>Action</th>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->full_name}}</td>
            <td>{{$user->street_address}}</td>
            <td>{{$user->city}}</td>
            <td>{{$user->zip_code}}</td>
          </tr>
          @endforeach
        </tbody>
    </table>
</body>
</html>
