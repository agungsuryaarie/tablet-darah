// Fungsi Jam
// window.onload = function () {
//     jam();
// };

// function jam() {
//     var e = document.getElementById("jam"),
//         d = new Date(),
//         h,
//         m,
//         s;
//     h = d.getHours();
//     m = set(d.getMinutes());
//     s = set(d.getSeconds());

//     e.innerHTML = h + ":" + m + ":" + s;

//     setTimeout("jam()", 1000);
// }

function set(e) {
    e = e < 10 ? "0" + e : e;
    return e;
}

// Fungsi Alert
function alertSuccess(message) {
    $("#alerts").html(
        '<div class="alert alert-success alert-dismissible fade show ml-2 mr-2 mt-2">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            "&times;</button><strong>Success! </strong>" +
            message +
            "</div>"
    );
    $(window).scrollTop(0);
    setTimeout(function () {
        $(".alert").alert("close");
    }, 5000);
}

function alertDanger(message) {
    $("#alerts").html(
        '<div class="alert alert-danger alert-dismissible fade show ml-2 mr-2 mt-2">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            "&times;</button><strong>Success! </strong>" +
            message +
            "</div>"
    );
    $(window).scrollTop(0);
    setTimeout(function () {
        $(".alert").alert("close");
    }, 5000);
}
