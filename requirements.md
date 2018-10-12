## Goal

Make it possible for customers to schedule a booking online.


## Requirements

- All models and columns should have validation as described in the model spec below, plus any common-sense validation you'll put on new models.

- We need to split the site in to Admin-only and Customer-only. Right now all the admin functionality is exposed to the world. 

- Currently we operate in 10 cities, but plan to expand quickly. 
	- We need a way to admin the list of cities we operate in and the ability to add to the list. You should create a new table to do this. 
	- On the admin cleaner form we need a way to select the cities a cleaner works in. This should be a checkbox list populated by the list of cities we operate in. You may need to create a new table to store this data.

- We need a way for customers to signup and schedule a booking all on one form. To accomplish this you will need to do the following: 
	- Make the site root a customer-facing form designed for customers to sign up and book a cleaner. 
	- On this form, capture all the data needed to create a customer in the database (first name, last name, phone number). 
	- If the customer already exists in the database (use phone number to determine this) use the existing record instead of creating a new one. You should probably add a validation to enforce this. 
	- Let the customer select what city they are in from the cities table created earlier. 
	- Let the customer specify a date, time, and number of hours for the home cleaning. 
	- When the user submits the form, look for cleaners that work in the specified city that do not have any bookings that conflict with the time specified. 
		- If you can find an available cleaner, create the booking and display the name of the cleaner assigned to the booking. 
		- If you can't find an available cleaner, tell the user that we could not fulfill their request. 
	- Don't forget to create a good experience for customers who are trying to book a cleaner -- think about it from their perspective.

- If you create a password-protected account, use credentials "admin@admin.com" and password "adminadmin".

- Existing Models:
	- customer 
		- first_name (required) 
		- last_name (required) 
		- phone_number (optional)
	- booking customer (required, enforce referential integrity) 
	- cleaner (required, enforce referential integrity) 
		- date (required) 
		- cleaner first_name (required) 
		- last_name (required) 
		- quality_score (required, must be a number between 0.0 and 5.0)
