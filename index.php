<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    input[type="text"],
    select {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      width: 100%;
      background-color: #4caf50;
      color: white;
      padding: 12px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <h2>APLIKASI PEMESANAN TIKET TRAVEL</h2>
    <form id="travelForm" method="POST">
      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" required />

      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="laki">Laki-laki</option>
        <option value="perempuan">perempuan</option>
      </select>

      <label for="tujuan">Tujuan:</label>
      <select id="tujuan" name="tujuan">
        <option value="Jakarta">Jakarta</option>
        <option value="Surabaya">Surabaya</option>
        <option value="Medan">Medan</option>
        <option value="Bandung">Bandung</option>
      </select>

      <label for="harga">Harga Tiket:</label>
      <input type="text" id="harga" name="harga" required />

      <label for="jumlah">Jumlah Tiket:</label>
      <select id="jumlah" name="jumlah">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
      </select>

      <label for="member">Member:</label>
      <select id="member" name="member">
        <option value="1">Member 1</option>
        <option value="2">Member 2</option>
        <option value="3">Member 3</option>
      </select>

      <label for="total">Total Bayar:</label>
      <input type="text" id="total" name="total" />

      <button class="btn btn-success w-100 mt-3" onclick="subForm()" type="button" value="Hitung Total">Save</button>
    </form>
  </div>

  <!-- <script>
      function hitungTotal() {
        var harga = parseFloat(document.getElementById("harga").value);
        var jumlah = parseFloat(document.getElementById("jumlah").value);
        var member = document.getElementById("member").value;

        var diskon = 0;
        if (member === "1") {
          diskon = 10;
        } else if (member === "2") {
          diskon = 20;
        } else if (member === "3") {
          diskon = 30;
        }

        var total = harga * jumlah;

        if (diskon > 0) {
          total *= (100 - diskon) / 100;
        }

        document.getElementById("total").value = total;
      }
    </script> -->
  <script>
    const endpoint = 'https://api-mongodb.vercel.app/';

    function submitForm() {
      const formData = new FormData(document.getElementById('travelForm'));
      const jsonData = {};

      formData.forEach((value, key) => {
        jsonData[key] = value;
      });

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'https://api-mongodb.vercel.app/', true);
      xhr.setRequestHeader('Content-Type', 'application/json'); // Set content type to JSON

      xhr.onreadystatechange = function() {
        if (xhr.status === 201) {
          console.log('Siswa created successfully:', JSON.parse(xhr.responseText));
          alert("Berhasil Membeli Tiket!");
          window.location.href = 'travel.php';
        } else {
          console.error('Error creating Siswa:', JSON.parse(xhr.responseText));
          alert("Gagal Membeli Tiket, silahkan refresh dan coba lagi!");
        }

      }

      xhr.send(JSON.stringify(jsonData)); // Convert data to JSON before sending
    }

    // Function to check if $_GET['id'] is set
    function isIdSet() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.has('id');
    }

    function subForm() {
      if (isIdSet()) {
        editTravel(new URLSearchParams(window.location.search).get('id'));
      } else {
        submitForm();
      }
    }

    // Function to edit a travel record
    function editTravel(travelId) {

      const formData = new FormData(document.getElementById('travelForm'));
      const jsonData = {};

      formData.forEach((value, key) => {
        jsonData[key] = value;
      });

      const xhr = new XMLHttpRequest();
      xhr.open('PATCH', `${endpoint}${travelId}`, true);
      xhr.setRequestHeader('Content-Type', 'application/json'); // Set content type to JSON

      xhr.onreadystatechange = function() {
        console.log('Tiket created successfully:', JSON.parse(xhr.responseText));
        alert("Berhasil Membeli Tiket");
        window.location.href = 'travel.php';
      }

      xhr.send(JSON.stringify(jsonData));
    }


    // Function to fetch data by ID and set form values
    function fetchDataById() {
      const id = new URLSearchParams(window.location.search).get('id');
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `${endpoint}${id}`, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            setFormValues(data.data);
          } else {
            console.error('Error fetching data by ID:', xhr.statusText);
          }
        }
      };
      xhr.send();
    }
    // Function to set form values
    function setFormValues(data) {
      // Set form values based on the received data
      document.getElementById('nama').value = data.nama;
      document.getElementById('gender').value = data.gender;
      document.getElementById('tujuan').value = data.tujuan;
      document.getElementById('harga').value = data.harga;
      document.getElementById('jumlah').value = data.jumlah;
      document.getElementById('member').value = data.member;
      document.getElementById('total').value = data.total;
    }

    // Call functions based on whether $_GET['id'] is set
    if (isIdSet()) {
      fetchDataById();
    }
  </script>
</body>

</html>