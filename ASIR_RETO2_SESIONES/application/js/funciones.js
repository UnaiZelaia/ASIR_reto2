var timestamp = null;

function activarSensor(srn) {
    $.ajax({
        async: true,
        type: "POST",
        url: "model/ActivarSensorAdd.php",
        data: "&token=" + srn,
        dataType: "json",
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            if (json["filas"] === 1) {
                $("#activeSensorLocal").attr("disabled", true);
                $("#fingerPrint").css("display", "block");
            }
        }
    });
}


function addUser(srn) {
    var data = new FormData();
    var inputFile = document.getElementById("foto");
    var file = inputFile.files[0];
    if (file !== undefined) {
        data.append("foto", file);
    }
    data.append("token", srn);
    data.append("nombre", $("#nombre").val());
    data.append("apellido", $("#apellido").val());
    data.append("login", $("#login").val());
    $.ajax({
        async: true,
        type: "POST",
        url: "model/CrearUsuario.php",
        data: data,
        contentType: false,
        processData: false,
        cache: false,
        dataType: "json",
        success: function (data) {
            console.log(data);
            var json = JSON.parse(data);
            if (json["filas"] === 1) {
                $("#" + atob(srn)).attr("src", "imagenes/finger.png");
                $("#" + atob(srn) + "_texto").text("El sensor esta activado");
                showMessageBox("Usuario creado con exito", "success");
                $("#fingerPrint").css("display", "none");
            }
        }
    });
}



function cargar_push() {
    $.ajax({
        async: true,
        type: "POST",
        url: "model/httpush.php",
        data: "&timestamp=" + timestamp,
        dataType: "json",
        success: function (data) {
            var json = JSON.parse(JSON.stringify(data));

            timestamp = json["timestamp"];
            imageHuella = json["imgHuella"];
            tipo = json["tipo"];
            id = json["id"];
            $("#" + id + "_status").text(json["statusPlantilla"]);
            $("#" + id + "_texto").text(json["texto"]);
            if (imageHuella !== null) {
                $("#" + id).attr("src", "data:image/png;base64," + imageHuella);
                if (tipo === "leer") {
                    $("#documento").text(json["documento"]);
                    $("#nombre").text(json["nombre"]);
                    $("#imageUser").attr("src", "Model/imageUser.php?documento=" + json["documento"]);
                }
            }
            setTimeout("cargar_push()", 1000);
        }
    });
}


function showMessageBox(mensaje, type) {
    var clas = "";
    var icono = "";
    switch (type) {
        case "success":
            clas = "mensaje_success";
            icono = "imagenes/success_16.png";
            break;
        case "warning":
            clas = "mensaje_warning";
            icono = "imagenes/warning_16.png";
            break;
        case "danger":
            clas = "mensaje_danger";
            icono = "imagenes/danger_16.png";
            break;
    }

    $("#mensaje").addClass(clas);
    $("#txtMensaje").html(mensaje);
    $("#imageMenssage").attr("src", icono);
    $("#mensaje").fadeIn(5);
    setTimeout(function () {
        $("#mensaje").fadeOut(1500);
    }, 3000);

}






