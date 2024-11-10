# Before running the project and after cloning it
- Run `composer install`
- Then run `composer dump-autoload`

# Project Info:
The development was done out on an environment running `PHP 8.1.20`
- In the main url `\` you will see a super simple form to search for flights
- There is a `data\flightEvents.json` file that contains information for several example flights to and/or from any of the `city codes` listed below.
- All flights have a takeoff and/or arrival date for 11/11/2024 or 11/12/2024
- If you add the URL of the desired endpoint `/journeys/search` to the URL with the search parameters, for example: `/journeys/search?date=2024-11-11&from=BUE&to=MAD` you will see the json with the flights result

# City Codes
- `BUE - Buenos Aires, Argentina`
- `MAD - Madrid, España`
- `BCN - Barcelona, España`
- `JFK - Nueva York (JFK), Estados Unidos`
- `MIA - Miami, Estados Unidos`
- `LAX - Los Ángeles, Estados Unidos`
- `PMI - Palma de Mallorca, España`
- `LHR - Londres (Heathrow), Reino Unido`
- `CDG - París (Charles de Gaulle), Francia`
- `GRU - São Paulo (Guarulhos), Brasil`
- `FRA - Fráncfort, Alemania`
- `AMS - Ámsterdam, Países Bajos`
- `SYD - Sídney, Australia`
- `DXB - Dubái, Emiratos Árabes Unidos`
- `SCL - Santiago, Chile`
- `LIM - Lima, Perú`
- `PTY - Ciudad de Panamá, Panamá`