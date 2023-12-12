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
    xhr.open("POST", "/admin/saveTicket", true);

    // Configura la función de devolución de llamada cuando la solicitud esté completa
    // Configura la función de devolución de llamada cuando la solicitud esté completa
    // Configura la función de devolución de llamada cuando la solicitud esté completa
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        // Verifica si la solicitud se ha completado
        if (xhr.status === 200) {
          // La solicitud fue exitosa, puedes manejar la respuesta aquí
          console.log("to' bien ");
          console.log(xhr.responseText); // Imprime la respuesta del servidor en la consola

          // Intenta analizar la respuesta JSON solo si es un JSON válido
          try {
            var jsonResponse = JSON.parse(xhr.responseText);
            if (jsonResponse.success) {
              console.log("Operación exitosa:", jsonResponse.message);
              console.log("Datos del ticket:", jsonResponse.data);

              // Muestra el mensaje en el contenedor de mensajes
              var messageContainer =
                document.getElementById("message-container");
              messageContainer.innerHTML =
                '<div class="success-message">¡Ticket creado con éxito!</div>';
            } else {
              console.error(
                "Error al guardar el ticket:",
                jsonResponse.message
              );
              console.error("Detalles del error:", jsonResponse.error);
            }
          } catch (error) {
            console.error("Error al analizar la respuesta JSON:", error);
          }
        } else {
          // La solicitud falló, maneja el error aquí
          console.error(
            "Error al enviar la solicitud. Código de estado: " + xhr.status
          );
          console.error(xhr.statusText);
        }
      }
    };

    // Envía los datos al servidor
    xhr.send(formData);
  });
