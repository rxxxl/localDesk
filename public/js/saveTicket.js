document
  .getElementById("ticketForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Evita que el formulario se envíe de manera predeterminada

    // Obtén los valores de los campos del formulario
    var issue = document.getElementById("issue").value;
    var area = document.getElementById("area").value;
    var priority = document.getElementById("priority").value;
    var desireResolutionDate = document.getElementById(
      "desireResolutionDate"
    ).value;
    var photo = document.getElementById("dropzone-file").files[0];

    // Crea un objeto FormData y agrega los datos del formulario
    var formData = new FormData();
    formData.append("issue", issue);
    formData.append("area", area);
    formData.append("priority", priority);
    formData.append("desireResolutionDate", desireResolutionDate);
    formData.append("photo", photo);

    // Utiliza AJAX para enviar los datos al servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/tickets/saveTicket", true);

    // Configura la función de devolución de llamada cuando la solicitud esté completa
    
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Redirige a /admin/showtickets después de 3 segundos (ajusta según tu preferencia)
        setTimeout(function () {
          window.location.href = "/tickets/showtickets";
        }, 3000);
      }
    };

    // Envía los datos al servidor
    xhr.send(formData);
  });
