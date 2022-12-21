document.getElementById("form").addEventListener("submit", function(event) {
    event.preventDefault();
  
    // Validate name
    var nameInput = document.getElementById("name");
    if (!nameInput.checkValidity()) {
      // Display an error message
      document.getElementById("name-error").innerHTML = nameInput.validationMessage;
    } else {
      // Clear the error message
      document.getElementById("name-error").innerHTML = "";
    }
  
    // Validate surname
    var surnameInput = document.getElementById("surname");
    if (!surnameInput.checkValidity()) {
      // Display an error message
      document.getElementById("surname-error").innerHTML = surnameInput.validationMessage;
    } else {
      // Clear the error message
      document.getElementById("surname-error").innerHTML = "";
    }
  
    // Validate cpf
    var cpfInput = document.getElementById("cpf");
    if (!cpfInput.checkValidity()) {
      // Display an error message
      document.getElementById("cpf-error").innerHTML = cpfInput.validationMessage;
    } else {
      // Clear the error message
      document.getElementById("cpf-error").innerHTML = "";
    }
  
    // Check if all fields are valid
    if (nameInput.checkValidity() && surnameInput.checkValidity() && cpfInput.checkValidity()) {
      // Submit the form
      document.getElementById("form").submit();
    }
  });
  

  // Search ajax
  $(document).ready(function(){
    $('#search-button').on('click', function(e) {
      e.preventDefault();
      var searchQuery = $('#search-query').val();
      var filter = $('#filter').val();
  
      $.ajax({
        url: 'search.php',
        type: 'GET',
        data: {
          search: searchQuery,
          filter: filter
        },
        success: function(data) {
          var result = JSON.parse(data);
          updateTable(result);
        }
      });
    });
  });
  
  function updateTable(data) {
    $('tbody').empty();
    for (var i = 0; i < data.length; i++) {
      var row = '<tr>';
      row += '<td>' + data[i].id + '</td>';
      row += '<td>' + data[i].name + '</td>';
      row += '<td>' + data[i].sobrenome + '</td>';
      row += '<td>' + data[i].cpf + '</td>';
      row += '<td>' + data[i].casos + '</td>';
      row += '</tr>';
      $('tbody').append(row);
    }
  }
  