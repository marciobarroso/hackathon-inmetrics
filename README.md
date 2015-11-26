#hackathon-inmetrics

Esquadrão Classe A
Rodolfo
Projeto Top5

# Project Structure (Please dont change it)
Rodolfo
- root (save in this level only html files)
	- resources (save in this level only resources *.css, *.jpg, *.png, *.js)
		- css (custom css)
		- data (custom datasets)
		- images (custom images)
		- js (custom javascript)
	- vendors (save in this level only third-party libraries without customizations)
		- bootstrap (all needed for bootstrap)
		- jquery (all needed for jquery)
	- README.md
	- index.html



# Fontes
Google API Geo Localização - https://developers.google.com/web/fundamentals/native-hardware/user-location/obtain-location#when-to-use-geolocation

Google API Places Search - https://developers.google.com/places/web-service/search

# Chamada da API Google Server Side
http://ec2-52-91-21-223.compute-1.amazonaws.com/resources/data/google.php?action=nearby&query=restaurante&latitude=-33.407187799999996&longitude=-70.5680272

Você pode mudar nessa URL a query, latitude e longitude. Ao carregar a pagina principal, no console aparece suas coordenadas