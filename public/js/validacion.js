function validar_clave() {
    var clave_uno = $("#password_uno").val();
    var valid = $("#password_dos").val();
    if (clave_uno == valid) {
        $("#btn_guardar").attr('disabled', false);
    } else {
        $("#btn_guardar").attr('disabled', true);
    }
}

function ver_clave() {
    var clave_uno = document.querySelector('#password_uno');
    if (clave_uno.type == 'password') {
        $('#password_uno').attr('type', 'text');
        $('#password_dos').attr('type', 'text');
    } else {
        $('#password_uno').attr('type', 'password');
        $('#password_dos').attr('type', 'password');
    }
}

function img_producto() {
    var img = event.target.files[0];
    console.log(img);
    document.getElementById('image_producto').src = URL.createObjectURL(event.target.files[0]);
}

function nombre_img() {
    var clave = document.getElementsByName("codigo");
    var nombre = document.getElementsByName("producto");
    var input = document.getElementById('img');
    var nomb2 = nombre[0].value.substring(0, 4);
    var nombre3 = clave[0].value + "-" + nomb2;
    var objeto = input.files[0];
    var nombre_archivo = objeto.name;
    var tipo = nombre_archivo.split('.');
    var nom_img = nombre3 + "." + tipo[1];
    document.getElementById('nombre_imagen').value = nom_img;
}

function numeros(event) {
    var code = (event.which) ? event.which : event.keyCode;

    if (code == 46) {
        return true;
    } else if (code >= 48 && code <= 57) { // rango de numero codigo ascii
        return true;
    } else { // otra tecla diferente
        return false;
    }
}

function nombre_file() {
    var clave = document.getElementsByName("codigo");
    var nombre = document.getElementsByName("producto");
    var nomb2 = nombre[0].value.substring(0, 4);
    var nombre3 = clave[0].value + "-" + nomb2;
    var input = document.getElementById('img');
    var objeto = input.files[0];
    var nombre_archivo = objeto.name;
    var tipo = nombre_archivo.split('.');
    var nom_img = nombre3 + "." + tipo[1];
    document.getElementById('nombre_imagen').value = nom_img;
}