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

https://maps.googleapis.com/maps/api/place/photo?photoreference=CmRdAAAA2G5BBviKpDy8cqrTi-5CBzIQOopIcD0Mdrnq3RAmOuBntZB5KyFo6u6Xz-0ArpmkbuYjBoDxFxWMuIiI132P6VMaCfQM1P-xqZYxNpzQFYhJAdluxvrN18WRBpZRB6LAEhC_ZuihYn0IuXp6GQUmvgPMGhQex4JT9c3vtgV_yr-8-5g-sOEZTA&sensor=false&maxheight=150&maxwidth=250&key=AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs


https://maps.googleapis.com/maps/api/place/photo?maxwidth=300&photoreference=CnRtAAAATLZNl354RwP_9UKbQ_5Psy40texXePv4oAlgP4qNEkdIrkyse7rPXYGd9D_Uj1rVsQdWT4oRz4QrYAJNpFX7rzqqMlZw2h2E2y5IKMUZ7ouD_SlcHxYq1yL4KbKUv3qtWgTK0A6QbGh87GB3sscrHRIQiG2RrmU_jF4tENr9wGS_YxoUSSDrYjWmrNfeEHSGSc3FyhNLlBU&key=AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs


https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ0YrcJ2bPYpYRh2h6mrxzbQ4&key=AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs

https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJN1t_tDeuEmsRUsoyG83frY4&key=

https://maps.googleapis.com/maps/api/place/textsearch/xml?location=-33.407187799999996,-70.5680272&radius=5000&query=restaurantes&key=AIzaSyDm743hCy0maE2farUjk4C24_udd5cLaXs