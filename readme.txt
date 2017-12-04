(Rare Eats) HITW - Checkpoint

Run vagrant up
Our project can be accessed at localhost:8080

You can:
- Create users
    - Click "login" from the navigation bar and register account
- Edit users
    - Must be logged in
    - Click "View Profile" from the navigation bar and click "Edit"
- Delete users
    - Must be logged in
    - Click "View Profile" from the navigation bar and click "Delete Account"
- Login using email address and password
    - Click "login" from the navigation bar and enter your email address and password
- Create restaurants (/restaurants/create)
- Edit restaurants (/restaurants/edit/<id>)
- Add tags to restaurants (ctrl+click to add multiple tags)
- View Restaurant (/restaurants/<id>)
- Remove tags from restaurants
- View list of restaurants (/restaurants)
- Create tags
- Delete tags
- Create playlist
    - Must be logged in
    - Click "View Profile" from navigation bar and click "Create New Playlist" under "My Lists"
- Edit playlist
- Delete playlist

Other Notes:
- All the lists under Featured Lists in the homepage are hardcoded placeholders. The links don't navigate anywhere
- "My Playlists" and "Recommended" in the navigation bar are placeholders. The links don't navigate anywhere


API Data:
-"Why did you use Foursquare over Google Places, or Zomato?
    -There are a few reasons for this.
        -The first reason is that neither Google Places nor Zomato allow the storage of their data.  We wanted to honor the TOS of these APIs, and as a result used Foursquare instead, which allows storage of its API data, so long as it is refreshed every 30 days.
        -The second is that Foursquare was the most familiar tool of the three to our team, letting us start development faster.
        -The third was that the functionality on the 'free' tier was more flexible for Foursquare than it was for Places or Zomato, despite having inferior data available and requiring more navigation.
-"What data did you scalp?"
    -Since this is not a live website, and is merely a demonstration, we chose a specific set of data to load.  This included restaurants from some cherrypicked categories, targeted to help us create recommendation lists based on time of day.
        -the general 'Food' category, which encompasses all restaurants
        -Breakfast
        -Cafes
        -Sandwiches
        -Comfort Food
-"What was the data querying process?"
    -The idea behind the website is to eliminate chain restaurants and fast food, leaving less well known restaurants, and hopefully higher quality overall.  In order to accomplish this without a large amount of manual data entry, we first loaded in a list of Categories from Foursquare.
    -These categories were then filtered to remove ones that we deemed as undesireable and not fitting the theme of the website.
        -Restaurants are loaded in if they contain one of these allowed categories, do not contain one of the banned ones, and are not a chain (ex: Cactus Club)
            -We then load in restaurants and photos for each of these restaurants - a static amount each.  This is done on migration on first load of the site.
    -We also make a call for the restaurant's latitude and longitude on access to individual restaurant pages.  This data is used to query Google Maps and provide users a way to navigate to the selected website.
        -This was not added to the database as it was a feature added late in the project, and one that some of our team was opposed to at the start of the project.
"What API features would you add given more time?"
    -If this were to become a full project, we would take in the user's location and suggest restaurants from the API based on where the user currently is.  Currently, it's just a set of sample data based on a relatively static JSON query.
        -This would have been in the base project, but the group was strongly against doing this - I don't know why.  They likely considered it to be too complex (it's really not).
    -If this project were to continue, the above location data would be added to the database, increasing overall stability of the website and reducing usage of the API.
    -As review data pulled from Foursquare does not contain a rating or a tagging system analogous to ours, I would consider adding tags from the user review text, as well as predicting how positive a review is based on the supplied text.
        -I would also allow reviews to push from our site to the Foursquare API.