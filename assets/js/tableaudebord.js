document.addEventListener("DOMContentLoaded", function () {
    const titreDate = document.getElementById("affichage-mois-annee");
    const zoneJours = document.getElementById("liste-jours-calendrier");
    const btnPrecedent = document.getElementById("btn-mois-precedent");
    const btnSuivant = document.getElementById("btn-mois-suivant");

    let dateActuelle = new Date();
    let anneeEnCours = dateActuelle.getFullYear();
    let moisEnCours = dateActuelle.getMonth();

    const nomsMois = [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre",
    ];

    function afficherCalendrier() {
        let premierJourDuMois = new Date(anneeEnCours, moisEnCours, 1).getDay();
        let dernierJourDuMois = new Date(
            anneeEnCours,
            moisEnCours + 1,
            0
        ).getDate();
        let dernierJourMoisPrecedent = new Date(
            anneeEnCours,
            moisEnCours,
            0
        ).getDate();

        let htmlListeJours = "";

        for (let i = premierJourDuMois; i > 0; i--) {
            htmlListeJours += `<div class="case-jour inactif">${dernierJourMoisPrecedent - i + 1
                }</div>`;
        }

        for (let i = 1; i <= dernierJourDuMois; i++) {
            let estAujourdhui =
                i === new Date().getDate() &&
                    moisEnCours === new Date().getMonth() &&
                    anneeEnCours === new Date().getFullYear()
                    ? "jour-actuel"
                    : "";

            htmlListeJours += `<div class="case-jour ${estAujourdhui}">${i}</div>`;
        }

        titreDate.innerText = `${nomsMois[moisEnCours]} ${anneeEnCours}`;
        zoneJours.innerHTML = htmlListeJours;
    }

    afficherCalendrier();

    btnPrecedent.addEventListener("click", () => {
        moisEnCours--;
        if (moisEnCours < 0) {
            moisEnCours = 11;
            anneeEnCours--;
        }
        afficherCalendrier();
    });

    btnSuivant.addEventListener("click", () => {
        moisEnCours++;
        if (moisEnCours > 11) {
            moisEnCours = 0;
            anneeEnCours++;
        }
        afficherCalendrier();
    });
});
