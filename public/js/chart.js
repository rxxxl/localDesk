const ctx = document.getElementById('myChart').getContext('2d');

var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
            'Completed',
            'Pending',
            'In Progress',
        ],
        datasets: [{
            label: 'Tasks',
            data: [12, 19, 3],
            backgroundColor: [
                'rgb(0, 255, 0)',
                'rgb(255, 0, 0)',
                'rgb(255, 255, 0)',
            ],
            hoverOffset: 4
        }]
    },
});