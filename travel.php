<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Data Table</title>
  <!-- Add Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="container mt-5">
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Gender</th>
          <th>Tujuan</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Member</th>
          <th>Total</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody id="travelTableBody"></tbody>
    </table>
  </div>

  <script>
    const endpoint = 'https://api-mongodb.vercel.app/';
    // Function to fetch and populate the table using XMLHttpRequest
    function fetchAndPopulateTable() {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `${endpoint}`, true); // Replace with your actual API endpoint
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            populateTable(data);
          } else {
            console.error('Error fetching data:', xhr.statusText);
          }
        }
      };
      xhr.send();
    }

    // Function to populate the table with data
    function populateTable(data) {
      const tableBody = document.getElementById('travelTableBody');
      tableBody.innerHTML = '';

      data.data.forEach((travel) => {
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${travel._id}</td>
        <td>${travel.nama}</td>
        <td>${travel.gender}</td>
        <td>${travel.tujuan}</td>
        <td>${travel.harga}</td>
        <td>${travel.jumlah}</td>
        <td>${travel.member}</td>
        <td>${travel.total}</td>
        <td><a class="btn btn-warning" href="index.php?id=${travel._id}">Edit</a></td>
        <td><button class="btn btn-danger" onclick="deleteTravel('${travel._id}')">Delete</button></td>
      `;
        tableBody.appendChild(row);
      });
    }

    // Function to delete a travel record
    function deleteTravel(travelId) {
      const confirmDelete = confirm('Are you sure you want to delete this record?'); // Replace with your actual delete logic
      if (confirmDelete) {
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `${endpoint}${travelId}`, true); // Replace with your actual API endpoint
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              console.log('Travel record deleted successfully');
              fetchAndPopulateTable();
            } else {
              console.error('Error deleting travel record:', xhr.statusText);
            }
          }
        };
        xhr.send();
      }
    }

    // Call the function to fetch and populate the table
    fetchAndPopulateTable();
  </script>

</body>

</html>