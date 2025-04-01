# Weather-App
Final Project Weather App

I've included a lot of comments in each file to try and help everyone know where to make edits. Basically, the program "mostly works" but I'm still working out some bugs. Luckily, we can use this repository to keep things up-to-date. During the construction, it is advised that we don't work on the same file at any given time so as to avoid destroying someone else's functionality as we implement our own but there are some failsafes in place to prevetn this, obviously.

ANYWAY, here is a breakdown of how the program works:

-Model is what manipulates our data. The .php files connect to our database AND the openweather API to pull the information and you can find any SQL manipulation there. There are many areas that can be improved. All SQL is stand-in and doesn't really include everthing we'll need.

-View is our UI, representing what users see and interact with.

-The controller is our intermediate layer between the two. It acts as sort of the methods behind the UI that interact with our Model. It determines what functions to call based on input.

To test the app, put everything as-is (subfolders, index.php in the base folder, etc) into a folder. I always name mine weather_app so I would suggest you do the same. NEXT, copy and move the entire weather_app folder into C:\xampp\htdocs\

If you haven't created the MySQL Database, do so. To access your MySQL database, launch XAMPP and click the admin button next to MySQL. On the left side there is a (New+) button on the file structure menu. Click that. 
Towards the top there is a menu, with Datbases, SQL, Status, User Accounts, etc. Clock on SQL. Paste your code from the .txt file here and, towards the bottom there is a button that says "go", click to run your code and generate your database. Until we make SQL changes you shouldn't need to edit this at all for each program you test. It's a stand-alone thing that the web program connects to.


Load up XAMPP and make sure Apache and MySQL are running. 
In your web browser, type: http://localhost/weather_app/
It should run! 

Cheers and make sure to hit me up if you have any questions. PHP can be a bit complex, but most of the stuff we'll be editiing will be the HTML, CSS, and SQL. However, if there are any improvements you want to make feel free. There are a wealth of good online resources and, while it brings its own issues EVERY TIME I TRY TO USE IT TO DEBUG, ChatGPT has helped a bit in my personal understanding of how this all works.
