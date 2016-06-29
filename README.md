# Facebook Opt In Button Instructions

### What does it do? 

This button when clicked sends a auth request to facebook. If a user is signed into Facebook it returns an authenticated token. 
If the user is not signed in to facebook it promts them to sign in, and then returns an authenticated token. 

Once the script has the token it queries Facebook api for the user's data. 

It pulls down first_name, last_name, and email. (still working on getting the phone)

Then it sends a query to Marapost to create a new user. 

Once the new user is created it redirects the user to http://www.sixpackshop.com


###  Instructions for use

###  Facebook 
	You're going to need to create a new facebook developer app and link the info from the app here

	fb_app_id 
	fb_app_secret'

	The facebook graph version at the time that I wrote this was v2.6'

	fb_default_graph_version

	the redirect url is where you want facebook to redirect its traffic to. In this example the url is set to local host. 
	When you launch this on a server you're goig to have to point facebook to the directory this file is located on. 
	Make sure you set the permisions correctly on this file so that it can be accessed externally. 

	fb_redirectUrl  


###  Maropost

	You're going to need to create a Maropost account and then create a new list. 


	the list id can be found in the browser url of a list you're viewing or a list you just created.
	MP_listId
	MP_auth_token
	MP_url_api




###  Final redirect Url 
	this is where we send the user when we are done. By default its set to sixpackshop.
