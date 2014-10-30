#Database
##Tables
###User
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
OIB | int(11) | -
name | varchar(40) | first name
surname | varchar(40) | last name
email | varchar(70) | valid email address
password | varchar(64) | hashed password
phone | varchar(20) | phone number
creditCardNumber | int(20) | credit card number
lastLogin | timestamp | time of the last login

###Reservation
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
userId | int(11) | foreign key user(id)
type | enum('instant','recurring','permanent') | reservation type
parkingSpotId | int(11) | foreign key parkingSpot(id)
start | timestamp | when does reservation start
end | timestamp | when does reservation end
duration | timestamp | how long does reservation last
period | timestamp | how often does reservation repeat

###ParkingSpot
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
parkingId | int(11) | foreign key parking(id)
sensor | boolean | true = taken, false = free

###Parking
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
locationId | int(11) | foreign key location(id)
type | enum('garage','outdoor') | parking type
numOfParkingSpots | int(11) | *maximum* number of parking spots
companyId | int(11) | foreign key company(id)
cost | int(11) | cost of parking per hour

##Indexes

