<?php

    session_start();

    if (!isset($_SESSION["uuid"]))
        $_SESSION["uuid"] = uniqid(rand(), true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>vMB E-Mail Tester</title>

    <!-- Bootstrap -->
    <link href="lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="tester.css" rel="stylesheet">
    <link href="theme/superhero.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="lib/html5shiv-3.7.2.min.js"></script>
    <script src="lib/respond-1.4.2.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0);">vMB E-Mail Tester</a>
        </div>
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>Ahoi Pirat!</h1>
        <p>Dies ist ein E-Mail-Tester für das hessische System der virtuellen Meinungsbilder (vMB). Trage einfach Deine in der Mitgliederverwaltung (MV) hinterlegte E-Mail-Adresse ein und wählen aus den verschiedenen Möglichkeiten eine E-Mail-Art aus.</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form class="">
                <div class="form-group">
                    <label class="control-label" for="email">Dies ist keine gültige E-Mail-Adresse</label>
                    <input type="text" placeholder="In der MV hinterlegte E-Mail-Adresse" class="form-control" id="email">
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <h2>Test E-Mail</h2>
            <p>Hiermit verschickt das Systen eine einfache Test-E-Mail mit einem lorem ipsum Text.</p>
            <p><a class="btn btn-info" href="javascript:sendMail('test');" role="button">Test E-Mail &raquo;</a></p>
        </div>
        <div class="col-md-3">
            <h2>Logo-vMB</h2>
            <p>Hiermit verschickt das System eine Kopie der <a target="_blank" href="https://vote-orga.piratenpartei-hessen.de/auswertung.php?id=86190&">[PPH Umfrage] Umfrage zum Logo des Landesverbandes</a>.<br />Dabei hast Du die Wahl, ob mit oder ohne simuliertes Token.</p>
            <p><a class="btn btn-primary" href="javascript:sendMail('vMB1-token');" role="button">Mit Token &raquo;</a></p>
            <p><a class="btn btn-default" href="javascript:sendMail('vMB1');" role="button">Ohne Token &raquo;</a></p>
        </div>
        <div class="col-md-3">
            <h2>Ramstein-vMB 1</h2>
            <p>Hiermit verschickt das System eine Kopie der <a target="_blank" href="https://vote-politik.piratenpartei-hessen.de/auswertung.php?id=56897&">[PPH Umfrage] Unterstützung der Ramstein Kampagne</a>.<br />Dabei hast Du die Wahl, ob mit oder ohne simuliertes Token.</p>
            <p><a class="btn btn-primary" href="javascript:sendMail('vMB2-token');" role="button">Mit Token &raquo;</a></p>
            <p><a class="btn btn-default" href="javascript:sendMail('vMB2');" role="button">Ohne Token &raquo;</a></p>
        </div>
        <div class="col-md-3">
            <h2>Ramstein-vMB 2</h2>
            <p>Hiermit verschickt das System eine Kopie der <a target="_blank" href="https://vote-politik.piratenpartei-hessen.de/auswertung.php?id=61943&">[PPH Umfrage] Forderungen der Ramstein Kampagne</a>.<br />Dabei hast Du die Wahl, ob mit oder ohne simuliertes Token.</p>
            <p><a class="btn btn-primary" href="javascript:sendMail('vMB3-token');" role="button">Mit Token &raquo;</a></p>
            <p><a class="btn btn-default" href="javascript:sendMail('vMB3');" role="button">Ohne Token &raquo;</a></p>
        </div>
    </div>
</div> <!-- /container -->

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            <a href="https://www.piratenpartei-hessen.de/kontakt">Kontakt</a>
            |
            <a href="https://www.piratenpartei-hessen.de/impressum">Impressum</a>
            |
            <a href="https://www.piratenpartei-hessen.de/datenschutzerklaerung">Datenschutzerklärung</a>
            <span style="float: right">&copy; Piratenpartei Hessen <?php echo date("Y"); ?></span>
        </p>
    </div>
</footer><!-- /footer -->

<!-- Modal -->
<div class="modal fade" id="meinModal" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="meinModalLabel">Ergebnis</h4>
            </div>
            <div class="modal-body" id="result"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="lib/jquery-1.11.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="lib/ba-debug.min.js"></script>
<script src="tester.js"></script>
<script>var uuid = "<?php echo hash_hmac('sha256', $_SESSION['uuid'], $_SERVER['REMOTE_ADDR']); ?>";</script>
</body>
</html>