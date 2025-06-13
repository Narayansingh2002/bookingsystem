# bookingsystem
A booking system built in php for customers to post their services, to allow customers to search and book them. It also comes with an admin section.

Features:

Explore Page - This page allows customers to search for all services and business owners, which means it limits how many clicks the user has to do get to their desired location.

Profile Page - Each user has a profile page to display their profile picture, name and account type. A business owner has an acitivity tab, to allow customers to keep up to date of their favourite service providers. Each user has the ability to delete their account and to update their name, profile picture, profile description and email address and password.

A business owner can create, edit and delete services, each service has it's own ID number, name, description, price and duration.

A customer can search and create bookings, as well as view all business owners.

An administrator can view, edit and delete all bookings, services and users.

This application includes:

User Authentication - Users can sign up using an email address and password, which can then choose their desired account type according to how they want to use the application, "Admin", "Owner", and "Customer". The user authentication includes login sessions and gives the ability to log out.

Role based Access Controls - As mention earlier, there are different account types on this application, which means i had to display different user interfaces according to the account type, to prevent a Customer from doing tasks which a Business Owner or Admin can only do, on top of that, I have designed each page that can only allow the desired user to access, for example you can see at the top of most php files, The application gets the User ID, and if the User ID matches with the desired account type the User will be granted access, if the user isn't granted access, the application will direct the user to the login page, which secures sensitive data for security purposes.
