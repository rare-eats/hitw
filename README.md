# Rare Eats

_Discover Restaurants You Love_

By _WebsiteDispenser_

## Access the Website

- Vagrant Up and navigate to http://localhost:8080/
- You may log in as Admin (see below for login info) or you may create an account to explore the functionality of the app

## What does it do?

- Facilitates finding food
- Gives you recommendations based on your preferences in restaurants
    - You need to create a list of restaurants to receive a recommendation

## Features:

- View restaurants in Vancouver
- Create Personalized lists of restaurants such as "Date Night" or "Post-Workout"
    - Add restaurants to lists by finding a restaurant you like and adding the list from the restaurant's view page
- Recommended restaurant lists generated based off your personal lists
- Add reviews and ratings to restaurants

## Technology Stack

- **Codeigniter**
    - Reason for using Codeigniter:
        - 3/6 people in our group had experience with PHP
    - Benefits of Codeigniter:
        - Simple MVC and installation
        - Not forced into a templating languge (besides PHP)
        - Comes with built-in protection against CSRF and XSS attacks
        - Documentation is really good (Mircea really likes it)
    - Issues with Codeigniter:
        - No Authentication Library
            - All User Authentication features created from scratch using Codeigniter's Session which

- **Foursquare**
    - "Why did you use Foursquare over Google Places, or Zomato?
        - There are a few reasons for this.
            - The first reason is that neither Google Places nor Zomato allow the storage of their data.  We wanted to honor the TOS of these APIs, and as a result used Foursquare instead, which allows storage of its API data, so long as it is refreshed every 30 days.
            - The second is that Foursquare was the most familiar tool of the three to our team, letting us start development faster.
            - The third was that the functionality on the 'free' tier was more flexible for Foursquare than it was for Places or Zomato, despite having inferior data available and requiring more navigation.
    - "What data did you scalp?"
        - Since this is not a live website, and is merely a demonstration, we chose a specific set of data to load.  This included restaurants from some cherrypicked categories, targeted to help us create recommendation lists based on time of day.
            - the general 'Food' category, which encompasses all restaurants
            - Breakfast
            - Cafes
            - Sandwiches
            - Comfort Food
    - "What was the data querying process?"
        - The idea behind the website is to eliminate chain restaurants and fast food, leaving less well known restaurants, and hopefully higher quality overall.  In order to accomplish this without a large amount of manual data entry, we first loaded in a list of Categories from Foursquare.
        - These categories were then filtered to remove ones that we deemed as undesireable and not fitting the theme of the website.
            - Restaurants are loaded in if they contain one of these allowed categories, do not contain one of the banned ones, and are not a chain (ex: Cactus Club)
                - We then load in restaurants and photos for each of these restaurants - a static amount each.  This is done on migration on first load of the site.
        - We also make a call for the restaurant's latitude and longitude on access to individual restaurant pages.  This data is used to query Google Maps and provide users a way to navigate to the selected website.
            -This was not added to the database as it was a feature added late in the project, and one that some of our team was opposed to at the start of the project.
    - "What API features would you add given more time?"
        - If this were to become a full project, we would take in the user's location and suggest restaurants from the API based on where the user currently is.  Currently, it's just a set of sample data based on a relatively static JSON query.
            - This would have been in the base project, but the group was strongly against doing this - I don't know why.  They likely considered it to be too complex (it's really not).
        - If this project were to continue, the above location data would be added to the database, increasing overall stability of the website and reducing usage of the API.
        - As review data pulled from Foursquare does not contain a rating or a tagging system analogous to ours, I would consider adding tags from the user review text, as well as predicting how positive a review is based on the supplied text.
            - I would also allow reviews to push from our site to the Foursquare API.

## Accounts

- Admin account:
    - overlord@example.com
    - pwd: admin
    - can edit/delete restaurants
    - can create/edit/delete tags
    - can delete user playlists

## Contributions

- Everyone:
    - Code Review
    - Debugging

- Jon:
    - API Integration with Foursquare to load restaurants, cuisine type tags
    - Photos, Reviews for each restaurant.
    - Google Maps link integration
    - Data filtering to remove unwanted cuisine types
    - Associating restaurants with tags

- Mircea
    - Restaurant CRUD
    - Restaurant Search
    - User Playlist search (shows all for admin, otherwise shows user’s private lists and public non-private lists)
    - Ratings Display on Restaurant Search
    - Font-Awesome Icons throughout site
    - Website design/styling across the board

- Isis
    - Reviews CRUD
    - Ratings (like/dislike) CRUD
    - Login redirect to original page

- Harris
    - User playlists CRUD
    - Adding/removing restaurants to/from playlists (contents table)
    - Subscribing to (unsubscribing from) playlists
    - Viewing of playlists by author, viewing all subscribed playlists

- Farzin
    - CRUD + Search for Users (no scaffolding in codeigniter)
    - Login/Maintaining Session (No Authentication library in Codeigniter)
    - Landing page (only the jumbotron bit)
    - Auto Playlists (recommendations) creation based off tags in a user's playlists, season, or time of day (breakfast/lunch/dinner)

- Piet
    - Initial database design
    - Initial website groundwork
    - Add/Remove tags to/from restaurants
    - All of poster design
    - Knowledge of CodeIgniter
    - Vagrant (and webserver) setup

## Known Bugs/Issues/TODOs:

(QA Testing By Andy Sun)
- Subscription to a public list that is later turned private still shows up on the list of subscribed lists but the subscribed user cannot access it because its been made private
- Password cannot be reset
- No proper admin panel. Admin cannot edit user information or view individual user profiles
