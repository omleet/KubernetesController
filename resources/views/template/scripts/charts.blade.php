    <script>
        const ctx = document.getElementById('totalResources').getContext('2d');
        const resourcesData = {
            labels: ['Namespaces ({{$resources['namespaces']}})', 'Pods ({{$resources['pods']}})', 'Deployments ({{$resources['deployments']}})', 'Services ({{$resources['services']}})', 'Ingresses ({{$resources['ingresses']}})'],
            datasets: [{
                label: 'Total',
                data: [{{$resources['namespaces']}}, {{$resources['pods']}}, {{$resources['deployments']}}, {{$resources['services']}}, {{$resources['ingresses']}}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: resourcesData,
            options: {
                responsive: true,
            }
        });
    </script>