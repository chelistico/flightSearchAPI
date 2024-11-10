<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <h1>Search for Flights</h1>

    <form id="flightSearchForm">
        <label for="date">Departure Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="from">From:</label>
        <input type="text" id="from" name="from" required placeholder="e.g., BUE">

        <label for="to">To:</label>
        <input type="text" id="to" name="to" required placeholder="e.g., MIA">

        <button type="submit">Search</button>
    </form>

    <h2>Search Results</h2>
    <table id="resultsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Connections</th>
                <th>Flight Path</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <h3>City Codes</h3>
    <ul>
        <li>BUE - Buenos Aires, Argentina</li>
        <li>MAD - Madrid, España</li>
        <li>BCN - Barcelona, España</li>
        <li>JFK - Nueva York (JFK), Estados Unidos</li>
        <li>MIA - Miami, Estados Unidos</li>
        <li>LAX - Los Ángeles, Estados Unidos</li>
        <li>PMI - Palma de Mallorca, España</li>
        <li>LHR - Londres (Heathrow), Reino Unido</li>
        <li>CDG - París (Charles de Gaulle), Francia</li>
        <li>GRU - São Paulo (Guarulhos), Brasil</li>
        <li>FRA - Fráncfort, Alemania</li>
        <li>AMS - Ámsterdam, Países Bajos</li>
        <li>SYD - Sídney, Australia</li>
        <li>DXB - Dubái, Emiratos Árabes Unidos</li>
        <li>SCL - Santiago, Chile</li>
        <li>LIM - Lima, Perú</li>
        <li>PTY - Ciudad de Panamá, Panamá</li>
    </ul>
    <script>
        $(document).ready(function() {
            const table = $('#resultsTable').DataTable();

            $('#flightSearchForm').on('submit', function(event) {
                event.preventDefault();

                const date = $('#date').val();
                const from = $('#from').val();
                const to = $('#to').val();

                $.ajax({
                    url: '/journeys/search',
                    method: 'GET',
                    data: {
                        date,
                        from,
                        to
                    },
                    success: function(response) {
                        table.clear();

                        response.forEach(function(journey) {
                            const connections = journey.connections;
                            const flightPath = journey.path.map(flight => `
                                <div>
                                    Flight: ${flight.flight_number}, 
                                    From: ${flight.from}, 
                                    To: ${flight.to}, 
                                    Departure: ${flight.departure_time}, 
                                    Arrival: ${flight.arrival_time}
                                </div>
                            `).join('');

                            table.row.add([connections, flightPath]);
                        });

                        table.draw();
                    },
                    error: function() {
                        alert("Error retrieving flight data. Please try again.");
                    }
                });
            });
        });
    </script>
</body>

</html>