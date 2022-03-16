// const ctx = document.getElementById('myChart').getContext('2d');
// const myChart = new Chart(ctx, {
//     type: 'polarArea',
//     data: {
//         labels: ['Antalgique', 'Antidépresseur', 'Antiinflamatoire', 'anxiolitique'],
//         datasets: [{
//             label: 'Nombre de médicament',
//             data: [12, 19, 3, 5],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     title: {
//         display: true,
//         text: 'Nombre de médicament par famille',
//         padding: {
//             top: 10,
//             bottom: 30
//         }
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });


const graphGauche = document.getElementById('graphiqueGauche');
const chartGauche = new Chart(graphGauche, {
    type: "polarArea",
    data: {
        labels: ['Antalgique', 'Antidépresseur', 'Antiinflamatoire', 'anxiolitique'],
        datasets: [{
            data: [12, 18, 3, 5],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    }
})

const graphDroite = document.getElementById('graphiqueDroite');
const chartDroite = new Chart(graphDroite, {
    type: "bar",
    data: {
        labels: ['Antalgique', 'Antidépresseur', 'Antiinflamatoire', 'anxiolitique'],
        datasets: [{
            data: [12, 19, 3, 5],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
        }]
    }
})