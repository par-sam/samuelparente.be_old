$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});

let modal = document.getElementById("modal");
let notif = document.getElementById("notif");
let notif_title = document.getElementById("notif_title");
let notif_content = document.getElementById("notif_content");
let notif_icon = document.getElementById("notif_icon");

$(document).on('click', '#form_btn', function (event) {
    event.preventDefault();

    fadeIn(modal)
});

$(document).on("click", "#form_send", function (event) {
    event.preventDefault();

    let name = $("#name").val();
    let email = $("#email").val();
    let message = $("#message").val();

    if (name && email && message) {
        $.ajax({
            url: "/assets/scripts/contact.php",
            method: "POST",
            data: {
                name: name,
                email: email,
                message: message
            }
        }).done(function (response) {
            fadeOut(modal);
            $("#name").val("");
            $("#email").val("");
            $("#message").val("");

            notif_title.innerHTML = "Message envoyé!";
            notif_content.innerHTML = "Votre message à été envoyé avec succès!";
            notif_icon.src = "/assets/img/check.png";
            
            fadeIn(notif)
            setTimeout(function () {
                fadeOut(notif)
            }, 3000);
        }
        ).fail(function () {
            notif_title.innerHTML = "Erreur";
            notif_content.innerHTML = "Erreur dans l'envoi de votre message, veuillez réessayer!";
            notif_icon.src = "/assets/img/cross.png";
            
            fadeIn(notif)
            setTimeout(function () {
                fadeOut(notif)
            }, 3000);
        }
        );
    } else {
        notif_title.innerHTML = "Erreur";
        notif_content.innerHTML = "Vous devez remplir tous les champs!";
        notif_icon.src = "/assets/img/cross.png";
        
        fadeIn(notif)
        setTimeout(function () {
            fadeOut(notif)
        }, 3000);
    }
});

$(document).on('click', '#login_btn', function (event) {
    event.preventDefault();

    let username = $("#username").val();
    let password = $("#password").val();

    if (username && password) {
        $.ajax({
            url: "/assets/scripts/login.php",
            method: "POST",
            data: {
                username: username,
                password: password
            }
        }).done(function (response) {
            if (response == "success") {
                notif_title.innerHTML = "Connexion réussie!";
                notif_content.innerHTML = "Vous êtes maintenant connecté!";
                notif_icon.src = "/assets/img/check.png";

                fadeIn(notif)
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                notif_title.innerHTML = "Erreur";
                notif_content.innerHTML = "Votre nom d'utilisateur ou votre mot de passe est incorrect!";
                notif_icon.src = "/assets/img/cross.png";

                fadeIn(notif)
                setTimeout(function () {
                    fadeOut(notif)
                }, 3000)
            }
        });
    } else {
        notif_title.innerHTML = "Erreur";
        notif_content.innerHTML = "Vous devez remplir tous les champs!";
        notif_icon.src = "/assets/img/cross.png";

        fadeIn(notif)
        setTimeout(function () {
            fadeOut(notif)
        }, 3000)
    }
});

function modalHandler(val) {
    if (val) {
        fadeIn(modal);
    } else {
        fadeOut(modal);
    }
}

function fadeOut(el) {
    el.style.opacity = 1;
    (function fade() {
        if ((el.style.opacity -= 0.1) < 0) {
            el.style.display = "none";
        } else {
            requestAnimationFrame(fade);
        }
    })();
}

function fadeIn(el, display) {
    el.style.opacity = 0;
    el.style.display = display || "flex";
    (function fade() {
        let val = parseFloat(el.style.opacity);
        if (!((val += 0.2) > 1)) {
            el.style.opacity = val;
            requestAnimationFrame(fade);
        }
    })();
}