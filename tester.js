/**
 * Created by nowrap on 13.09.2015.
 */
function sendMail(target) {
    debug.log("sendMail");
    debug.log(target);

    var email = $("#email").val();
    email = $.trim(email);
    debug.log(email);

    if (!isMail(email)) {
        $("#email").parent().addClass("has-error");
        return;
    }

    $.ajax({
        url: 'sendMail.php',
        type: 'post',
        data: {'action': 'sendMail', 'email': email, 'uuid': uuid, 'target': target},
        success: function(data, status) {
            debug.log(data);
            if (data.success) {
                $("#result").html("Die E-Mail wurde korrekt an den Mail-Server übergeben!");
            } else {
                $("#result").html("Der Mail-Server hat die E-Mail nicht akzeptiert!");
            }
            $('#meinModal').modal();
        },
        error: function(xhr, desc, err) {
            debug.log(xhr);
            debug.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function isMail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}