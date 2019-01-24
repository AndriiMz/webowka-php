1. docker-compose up -d
2. open browser on http://localhost:8002
3. run http://localhost:8002/src/installDb.php to initialize database
4. then go to http://localhost:8002/ and  click "Registration"

You can check if you have active user session on http://localhost:8002/home.php page

To login go to http://localhost:8002/ and click "Zaloguj"

Then to edit profile go to http://localhost:8002/home.php 

To switch theme go to http://localhost:8002/src/controller.php?action=styles&dark=1
if you want red theme change "dark" to "red", if you want to clear theme change it to "off"

To inspect session, cookies and database go to http://localhost:8002/inspect.php