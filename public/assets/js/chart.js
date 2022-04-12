const graphGauche = document.getElementById('graphiqueGauche');
const chartGauche = new Chart(graphGauche, {
    type: "polarArea",
    data: {
        labels: libelleFam,
        datasets: [{
            data: nbMedics,
            backgroundColor: colorOfMed,
            borderColor: borderColorOfMed,
            borderWidth: 1
        }]
    }
})


const graphDroite = document.getElementById('graphiqueDroite');
const chartDroite = new Chart(graphDroite, {
    type: "doughnut",
    data: {
        labels: libelleTab,
        datasets: [{
            data: totalTab,
            backgroundColor: colorOfPresc,
            borderColor: borderColorOfPresc,
            borderWidth: 1
        }]
    }
})