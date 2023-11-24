--    Populates tables. Make sure tables are created first.

-- REMOVE THIS COMMENT LATER. dml is for insert, delete, update statements. ddl is for create, drop, alter table statements

INSERT INTO AvailableDaysRegularVolunteer (availableDays, regularVolunteer) VALUES ('TTTTTTT', 1);
INSERT INTO AvailableDaysRegularVolunteer (availableDays, regularVolunteer) VALUES ('TTTTTTF', 1);
INSERT INTO AvailableDaysRegularVolunteer (availableDays, regularVolunteer) VALUES ('TTTTFFF', 1);
INSERT INTO AvailableDaysRegularVolunteer (availableDays, regularVolunteer) VALUES ('TTFFFFF', 1);
INSERT INTO AvailableDaysRegularVolunteer (availableDays, regularVolunteer) VALUES ('FFFFFFF', 0);

INSERT INTO Volunteer (volunteerID, name, availableDays, phoneNumber) VALUES ('V123', 'Sam Johns', 'TTTTTTT', 1231231234);
INSERT INTO Volunteer (volunteerID, name, availableDays, phoneNumber) VALUES ('V124', 'Clara Yang', 'TTTTTTF', 1231239999);
INSERT INTO Volunteer (volunteerID, name, availableDays, phoneNumber) VALUES ('V125', 'Anna Smith', 'TTTTFFF', 7781111111);
INSERT INTO Volunteer (volunteerID, name, availableDays, phoneNumber) VALUES ('V126', 'Chase Jones', 'TTFFFFF', 1231231234);
INSERT INTO Volunteer (volunteerID, name, availableDays, phoneNumber) VALUES ('V127', 'Larry Miller', 'FFFFFFF', 2220004444);

INSERT INTO Inspector(insName,insID) VALUES ('Selina', 'I001');
INSERT INTO Inspector(insName,insID) VALUES ('Ece', 'I002');
INSERT INTO Inspector(insName,insID) VALUES ('Sogand', 'I003');
INSERT INTO Inspector(insName,insID) VALUES ('Tony', 'I004');
INSERT INTO Inspector(insName,insID) VALUES ('Zed', 'I005');

INSERT INTO Vet(vetID,vetName) VALUES ('V001', 'Andy');
INSERT INTO Vet(vetID,vetName) VALUES ('V002', 'Jack');
INSERT INTO Vet(vetID,vetName) VALUES ('V003', 'Mary');
INSERT INTO Vet(vetID,vetName) VALUES ('V004', 'Jackie');
INSERT INTO Vet(vetID,vetName) VALUES ('V005', 'Sandy');

INSERT INTO AdoptersLocation(postalCode, city, streetName, province) VALUES ('123456', 'Toronto', '120 Bremner Blvd', 'Ontario');
INSERT INTO AdoptersLocation(postalCode, city, streetName, province) VALUES ('34FS67', 'Toronto', '20 Bay Street', 'Ontario');
INSERT INTO AdoptersLocation(postalCode, city, streetName, province) VALUES ('45A67S8', 'Mississauga', '2375 Skymark Avenue', 'Ontario');
INSERT INTO AdoptersLocation(postalCode, city, streetName, province) VALUES ('V7TDZ4', 'Vancouver', NULL, 'British Columbia');
INSERT INTO AdoptersLocation(postalCode, city, streetName, province) VALUES ('444555', 'Cambridge', '705 Fountain Street N.', 'Ontario');

INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A000', '7290920930', 'Jane Smith', 7781234567, 'jane98smith@gmail.com', '123456', '12');
INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A001', '7599921838', 'Joe Johnson', 6449826543, 'joe.johnson@gmail.com', NULL, '17');
INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A002', '7899234932', 'Natalia Davis', 522-342-6189, 'nattyisb32.davis@gmail.com', '34FS67', '912');
INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A003', '7899980938', 'Jason Ng', 5671231212, 'jas65.ng@gmail.com', '45A67S8', '789');
INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A005', '7145980938', 'Clark Brown', 2355678912, 'clark.brown456@outlook.com', 'V7TDZ4', '23');
INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A006', '7166980938', 'Sara Brown', 2359929988, 'sara.brown6@outlook.com', '444555', '13');
INSERT INTO AdoptersInfo (adopterID, nationalID, name, phoneNumber, email, postalCode, houseNumber) VALUES ('A007', '7166000038', 'Andy Smith', 2352228888, 'andy.smith@outlook.com', '444555', '13');

INSERT INTO Shelter(shelterLocation,capacity,shelterName) VALUES ('270 Gerrard St E, Toronto, Ontario', 200, 'Lovely Pet Home');
INSERT INTO Shelter(shelterLocation,capacity,shelterName) VALUES ('322 Dundas St W, Toronto,Ontario', 150, 'Loving Care Animal Shelter');
INSERT INTO Shelter(shelterLocation,capacity,shelterName) VALUES ('101 Oak Street, Evacuationville, USA', 500, 'Lovely Pet Home');
INSERT INTO Shelter(shelterLocation,capacity,shelterName) VALUES ('10776 King George Boulevard, Surrey, British Columbia', 100, 'Paws and Claws Animal Shelter');
INSERT INTO Shelter(shelterLocation,capacity,shelterName) VALUES ('4455 110 Avenue SE, Calgary, Alberta', 300, 'The Animal Haven');
INSERT INTO Shelter(shelterLocation,capacity,shelterName) VALUES ('234 Willow Lane, Supportville, USA', 500, 'The Animal Haven');

INSERT INTO Inspect(insID,shelterLocation,shelterName,standardsMet) VALUES ('I001', '234 Willow Lane, Supportville, USA', 'The Animal Haven', 1);
INSERT INTO Inspect(insID,shelterLocation,shelterName,standardsMet) VALUES ('I002', '234 Willow Lane, Supportville, USA', 'The Animal Haven', 1);
INSERT INTO Inspect(insID,shelterLocation,shelterName,standardsMet) VALUES ('I002', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven', 1);
INSERT INTO Inspect(insID,shelterLocation,shelterName,standardsMet) VALUES ('I003', '10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter', 1);
INSERT INTO Inspect(insID,shelterLocation,shelterName,standardsMet) VALUES ('I004', '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home', 1);
INSERT INTO Inspect(insID,shelterLocation,shelterName,standardsMet) VALUES ('I004', '322 Dundas St W, Toronto,Ontario', 'Loving Care Animal Shelter', 0);

INSERT INTO Manager(manID,manPassword) VALUES ('M001', 'myt');
INSERT INTO Manager(manID,manPassword) VALUES ('M002', 'myt');
INSERT INTO Manager (manID, manPassword) VALUES ('M003', 'pass');
INSERT INTO Manager(manID,manPassword) VALUES ('M004', 'pass4');
INSERT INTO Manager (manID, manPassword) VALUES ('M005', 'pass5');

INSERT INTO VolunteersAtShelter (volunteerID, shelterLocation, shelterName, since) VALUES ('V123', '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home', TO_DATE('2023-11-11', 'YYYY-MM-DD'));
INSERT INTO VolunteersAtShelter (volunteerID, shelterLocation, shelterName, since) VALUES ('V124', '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home', TO_DATE('2023-10-27', 'YYYY-MM-DD'));
INSERT INTO VolunteersAtShelter (volunteerID, shelterLocation, shelterName, since) VALUES ('V125', '101 Oak Street, Evacuationville, USA', 'Lovely Pet Home',TO_DATE('2023-11-11', 'YYYY-MM-DD'));
INSERT INTO VolunteersAtShelter (volunteerID, shelterLocation, shelterName, since) VALUES ('V126', '10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter', TO_DATE('2007-01-01', 'YYYY-MM-DD'));
INSERT INTO VolunteersAtShelter (volunteerID, shelterLocation, shelterName, since) VALUES ('V126', '234 Willow Lane, Supportville, USA', 'The Animal Haven', TO_DATE('2010-08-04', 'YYYY-MM-DD'));