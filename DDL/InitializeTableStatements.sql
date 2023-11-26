DROP TABLE VolunteersAtShelter;

DROP TABLE Volunteer;

DROP TABLE AvailableDaysRegularVolunteer;

DROP TABLE EventsHosted;

DROP TABLE Vet;

DROP TABLE AdoptersInfo;

DROP TABLE AdoptersLocation;

DROP TABLE Inspect;

DROP TABLE Shelter;

DROP TABLE Inspector;

DROP TABLE Manager;

DROP TABLE RegisteredAnimal;

DROP TABLE Cats;

DROP TABLE Dogs;

DROP TABLE Birds;

DROP TABLE GetVaccination;

DROP TABLE Vaccination;

DROP TABLE HealthRecord;



CREATE TABLE
    AvailableDaysRegularVolunteer(
        availableDays char(7) PRIMARY KEY,
        regularVolunteer NUMBER(1, 0) NOT NULL
    );

CREATE TABLE
    Volunteer (
        volunteerID char(4) PRIMARY KEY,
        name varchar(255) NOT NULL,
        availableDays char(7),
        phoneNumber int,
        FOREIGN KEY (availableDays) REFERENCES AvailableDaysRegularVolunteer(availableDays)
    );

CREATE TABLE
    Inspector(
        insName VARCHAR(225) NOT NULL,
        insID CHAR(4),
        PRIMARY KEY (insID)
    );

CREATE TABLE
    Vet(
        vetID CHAR(4),
        vetName VARCHAR(225) NOT NULL,
        PRIMARY KEY (vetID)
    );

CREATE TABLE
    AdoptersLocation(
        postalCode VARCHAR(225),
        city VARCHAR(225),
        streetName VARCHAR(225),
        province VARCHAR(225),
        PRIMARY KEY (postalCode)
    );

CREATE TABLE
    AdoptersInfo(
        adopterID CHAR(4),
        nationalID CHAR(10) UNIQUE,
        name VARCHAR(225),
        phoneNumber INT,
        email VARCHAR(225) UNIQUE,
        postalCode VARCHAR(225),
        houseNumber VARCHAR(225),
        PRIMARY KEY (adopterID),
        FOREIGN KEY (postalCode) REFERENCES AdoptersLocation(postalCode) ON DELETE
        SET NULL
    );

CREATE TABLE
    Shelter(
        shelterLocation VARCHAR(225),
        capacity INT,
        shelterName VARCHAR(225),
        PRIMARY KEY (shelterLocation, shelterName)
    );

CREATE TABLE
    Inspect(
        insID CHAR(4),
        shelterLocation VARCHAR(225),
        shelterName VARCHAR(225),
        standardsMet NUMBER(1, 0),
        PRIMARY KEY (
            insID,
            shelterLocation,
            shelterName
        ),
        FOREIGN KEY (insID) REFERENCES Inspector(insID),
        FOREIGN KEY (shelterLocation, shelterName) REFERENCES Shelter(shelterLocation, shelterName)
    );

CREATE TABLE
    Manager(
        manID char(4),
        manPassword char(12),
        manName char(30) DEFAULT NULL,
        kpi char(30) DEFAULT NULL,
        PRIMARY KEY (manID)
    );

CREATE TABLE
    VolunteersAtShelter(
        volunteerID char(4),
        shelterLocation varchar(225),
        shelterName varchar(225),
        since date,
        PRIMARY KEY (
            volunteerID,
            shelterLocation,
            shelterName
        ),
        FOREIGN KEY (volunteerID) REFERENCES Volunteer(volunteerID),
        FOREIGN KEY (shelterName, shelterLocation) REFERENCES Shelter(shelterName, shelterLocation)
    );

CREATE TABLE
    EventsHosted(
        eventName varchar(225),
        eventDescription varchar(225),
        cost varchar(225),
        eventDate date,
        shelterLocation varchar(225),
        shelterName varchar(225),
        PRIMARY KEY (
            eventName,
            shelterLocation,
            shelterName
        ),
        FOREIGN KEY (shelterLocation, shelterName) REFERENCES Shelter
    );

CREATE TABLE
    RegisteredAnimal (
        animalID CHAR [4],
        name VARCHAR,
        adopted ? BOOLEAN,
        description VARCHAR,
        age INTEGER,
        weight INTEGER,
        breed VARCHAR,
        shelterLocation VARCHAR NOT NULL,
        shelterName VARCHAR NOT NULL,
        PRIMARY KEY (animalID),
        FOREIGN KEY (Shelter) REFERENCES Shelter(shelterLocation, shelterName)
    );

CREATE TABLE
    Cats (
        animalID CHAR [4],
        hasFur ? BOOLEAN,
        social ? BOOLEAN,
        PRIMARY KEY(animalID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID) ON DELETE CASCADE
    );

CREATE TABLE
    Dogs (
        animalID CHAR [4],
        medicallyTrained ? BOOLEAN,
        hasFur ? BOOLEAN,
        PRIMARY KEY(animalID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID) ON UPDATE CASCADE ON DELETE CASCADE
    );

CREATE TABLE
    Birds (
        animalID CHAR [4],
        beakSize INTEGER,
        wingSpan INTEGER,
        color VARCHAR,
        PRIMARY KEY(animalID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID) ON UPDATE CASCADE ON DELETE CASCADE
    );

CREATE TABLE
    GetVaccination (
        animalID CHAR [4],
        vaccinationName VARCHAR,
        dateOfVaccination DATE,
        PRIMARY KEY (animalID, vaccinationName),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID),
        FOREIGN KEY (vaccinationName) REFERENCES Vaccination(vaccinationName)
    );


CREATE TABLE Vaccination (
	 vaccineName varchar PRIMARY KEY,
	 expiryDate date NOT NULL,
	 recordID char(4) NOT NULL,
	FOREIGN KEY (recordID) REFERENCES HealthRecord(recordID)
    );


CREATE TABLE
    HealthRecord (
        recordID char(4) PRIMARY KEY,
        allergyInfo varchar,
        vetID char(4) NOT NULL,
        animalID char(4) NOT NULL,
        FOREIGN KEY (vetID) REFERENCES Vet(vetID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID)
    );

INSERT INTO
    AvailableDaysRegularVolunteer (
        availableDays,
        regularVolunteer
    )
VALUES ('TTTTTTT', 1);

INSERT INTO
    AvailableDaysRegularVolunteer (
        availableDays,
        regularVolunteer
    )
VALUES ('TTTTTTF', 1);

INSERT INTO
    AvailableDaysRegularVolunteer (
        availableDays,
        regularVolunteer
    )
VALUES ('TTTTFFF', 1);

INSERT INTO
    AvailableDaysRegularVolunteer (
        availableDays,
        regularVolunteer
    )
VALUES ('TTFFFFF', 1);

INSERT INTO
    AvailableDaysRegularVolunteer (
        availableDays,
        regularVolunteer
    )
VALUES ('FFFFFFF', 0);

INSERT INTO
    Volunteer (
        volunteerID,
        name,
        availableDays,
        phoneNumber
    )
VALUES (
        'V123',
        'Sam Johns',
        'TTTTTTT',
        1231231234
    );

INSERT INTO
    Volunteer (
        volunteerID,
        name,
        availableDays,
        phoneNumber
    )
VALUES (
        'V124',
        'Clara Yang',
        'TTTTTTF',
        1231239999
    );

INSERT INTO
    Volunteer (
        volunteerID,
        name,
        availableDays,
        phoneNumber
    )
VALUES (
        'V125',
        'Anna Smith',
        'TTTTFFF',
        7781111111
    );

INSERT INTO
    Volunteer (
        volunteerID,
        name,
        availableDays,
        phoneNumber
    )
VALUES (
        'V126',
        'Chase Jones',
        'TTFFFFF',
        1231231234
    );

INSERT INTO
    Volunteer (
        volunteerID,
        name,
        availableDays,
        phoneNumber
    )
VALUES (
        'V127',
        'Larry Miller',
        'FFFFFFF',
        2220004444
    );

INSERT INTO Inspector(insName, insID) VALUES ('Selina', 'I001');

INSERT INTO Inspector(insName, insID) VALUES ('Ece', 'I002');

INSERT INTO Inspector(insName, insID) VALUES ('Sogand', 'I003');

INSERT INTO Inspector(insName, insID) VALUES ('Tony', 'I004');

INSERT INTO Inspector(insName, insID) VALUES ('Zed', 'I005');

INSERT INTO Vet(vetID, vetName) VALUES ('V001', 'Andy');

INSERT INTO Vet(vetID, vetName) VALUES ('V002', 'Jack');

INSERT INTO Vet(vetID, vetName) VALUES ('V003', 'Mary');

INSERT INTO Vet(vetID, vetName) VALUES ('V004', 'Jackie');

INSERT INTO Vet(vetID, vetName) VALUES ('V005', 'Sandy');

INSERT INTO
    AdoptersLocation(
        postalCode,
        city,
        streetName,
        province
    )
VALUES (
        '123456',
        'Toronto',
        '120 Bremner Blvd',
        'Ontario'
    );

INSERT INTO
    AdoptersLocation(
        postalCode,
        city,
        streetName,
        province
    )
VALUES (
        '34FS67',
        'Toronto',
        '20 Bay Street',
        'Ontario'
    );

INSERT INTO
    AdoptersLocation(
        postalCode,
        city,
        streetName,
        province
    )
VALUES (
        '45A67S8',
        'Mississauga',
        '2375 Skymark Avenue',
        'Ontario'
    );

INSERT INTO
    AdoptersLocation(
        postalCode,
        city,
        streetName,
        province
    )
VALUES (
        'V7TDZ4',
        'Vancouver',
        NULL,
        'British Columbia'
    );

INSERT INTO
    AdoptersLocation(
        postalCode,
        city,
        streetName,
        province
    )
VALUES (
        '444555',
        'Cambridge',
        '705 Fountain Street N.',
        'Ontario'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A000',
        '7290920930',
        'Jane Smith',
        7781234567,
        'jane98smith@gmail.com',
        '123456',
        '12'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A001',
        '7599921838',
        'Joe Johnson',
        6449826543,
        'joe.johnson@gmail.com',
        NULL,
        '17'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A002',
        '7899234932',
        'Natalia Davis',
        522 -342 -6189,
        'nattyisb32.davis@gmail.com',
        '34FS67',
        '912'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A003',
        '7899980938',
        'Jason Ng',
        5671231212,
        'jas65.ng@gmail.com',
        '45A67S8',
        '789'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A005',
        '7145980938',
        'Clark Brown',
        2355678912,
        'clark.brown456@outlook.com',
        'V7TDZ4',
        '23'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A006',
        '7166980938',
        'Sara Brown',
        2359929988,
        'sara.brown6@outlook.com',
        '444555',
        '13'
    );

INSERT INTO
    AdoptersInfo (
        adopterID,
        nationalID,
        name,
        phoneNumber,
        email,
        postalCode,
        houseNumber
    )
VALUES (
        'A007',
        '7166000038',
        'Andy Smith',
        2352228888,
        'andy.smith@outlook.com',
        '444555',
        '13'
    );

INSERT INTO
    Shelter(
        shelterLocation,
        capacity,
        shelterName
    )
VALUES (
        '270 Gerrard St E, Toronto, Ontario',
        200,
        'Lovely Pet Home'
    );

INSERT INTO
    Shelter(
        shelterLocation,
        capacity,
        shelterName
    )
VALUES (
        '322 Dundas St W, Toronto,Ontario',
        150,
        'Loving Care Animal Shelter'
    );

INSERT INTO
    Shelter(
        shelterLocation,
        capacity,
        shelterName
    )
VALUES (
        '101 Oak Street, Evacuationville, USA',
        500,
        'Lovely Pet Home'
    );

INSERT INTO
    Shelter(
        shelterLocation,
        capacity,
        shelterName
    )
VALUES (
        '10776 King George Boulevard, Surrey, British Columbia',
        100,
        'Paws and Claws Animal Shelter'
    );

INSERT INTO
    Shelter(
        shelterLocation,
        capacity,
        shelterName
    )
VALUES (
        '4455 110 Avenue SE, Calgary, Alberta',
        300,
        'The Animal Haven'
    );

INSERT INTO
    Shelter(
        shelterLocation,
        capacity,
        shelterName
    )
VALUES (
        '234 Willow Lane, Supportville, USA',
        500,
        'The Animal Haven'
    );

INSERT INTO
    Inspect(
        insID,
        shelterLocation,
        shelterName,
        standardsMet
    )
VALUES (
        'I001',
        '234 Willow Lane, Supportville, USA',
        'The Animal Haven',
        1
    );

INSERT INTO
    Inspect(
        insID,
        shelterLocation,
        shelterName,
        standardsMet
    )
VALUES (
        'I002',
        '234 Willow Lane, Supportville, USA',
        'The Animal Haven',
        1
    );

INSERT INTO
    Inspect(
        insID,
        shelterLocation,
        shelterName,
        standardsMet
    )
VALUES (
        'I002',
        '4455 110 Avenue SE, Calgary, Alberta',
        'The Animal Haven',
        1
    );

INSERT INTO
    Inspect(
        insID,
        shelterLocation,
        shelterName,
        standardsMet
    )
VALUES (
        'I003',
        '10776 King George Boulevard, Surrey, British Columbia',
        'Paws and Claws Animal Shelter',
        1
    );

INSERT INTO
    Inspect(
        insID,
        shelterLocation,
        shelterName,
        standardsMet
    )
VALUES (
        'I004',
        '270 Gerrard St E, Toronto, Ontario',
        'Lovely Pet Home',
        1
    );

INSERT INTO
    Inspect(
        insID,
        shelterLocation,
        shelterName,
        standardsMet
    )
VALUES (
        'I004',
        '322 Dundas St W, Toronto,Ontario',
        'Loving Care Animal Shelter',
        0
    );

INSERT INTO Manager(manID, manPassword) VALUES ('M001', 'myt');

INSERT INTO Manager(manID, manPassword) VALUES ('M002', 'myt');

INSERT INTO Manager (manID, manPassword) VALUES ('M003', 'pass');

INSERT INTO Manager(manID, manPassword) VALUES ('M004', 'pass4');

INSERT INTO Manager (manID, manPassword) VALUES ('M005', 'pass5');

INSERT INTO
    VolunteersAtShelter (
        volunteerID,
        shelterLocation,
        shelterName,
        since
    )
VALUES (
        'V123',
        '270 Gerrard St E, Toronto, Ontario',
        'Lovely Pet Home',
        TO_DATE('2023-11-11', 'YYYY-MM-DD')
    );

INSERT INTO
    VolunteersAtShelter (
        volunteerID,
        shelterLocation,
        shelterName,
        since
    )
VALUES (
        'V124',
        '270 Gerrard St E, Toronto, Ontario',
        'Lovely Pet Home',
        TO_DATE('2023-10-27', 'YYYY-MM-DD')
    );

INSERT INTO
    VolunteersAtShelter (
        volunteerID,
        shelterLocation,
        shelterName,
        since
    )
VALUES (
        'V125',
        '101 Oak Street, Evacuationville, USA',
        'Lovely Pet Home',
        TO_DATE('2023-11-11', 'YYYY-MM-DD')
    );

INSERT INTO
    VolunteersAtShelter (
        volunteerID,
        shelterLocation,
        shelterName,
        since
    )
VALUES (
        'V126',
        '10776 King George Boulevard, Surrey, British Columbia',
        'Paws and Claws Animal Shelter',
        TO_DATE('2007-01-01', 'YYYY-MM-DD')
    );

INSERT INTO
    VolunteersAtShelter (
        volunteerID,
        shelterLocation,
        shelterName,
        since
    )
VALUES (
        'V126',
        '234 Willow Lane, Supportville, USA',
        'The Animal Haven',
        TO_DATE('2010-08-04', 'YYYY-MM-DD')
    );

INSERT INTO
    EventsHosted(
        eventName,
        eventDescription,
        cost,
        eventDate,
        shelterLocation,
        shelterName
    )
VALUES (
        'Adoption Party',
        'A fun event where you can meet and adopt adorable shelter pets',
        '$20 per person',
        TO_DATE('2022-05-20', 'YYYY-MM-DD'),
        '10776 King George Boulevard, Surrey, British Columbia',
        'Paws and Claws Animal Shelter'
    );

INSERT INTO
    EventsHosted(
        eventName,
        eventDescription,
        cost,
        eventDate,
        shelterLocation,
        shelterName
    )
VALUES (
        'Pet Play Day',
        'Playtime for pets and people with games and activities',
        '$10 per person',
        TO_DATE('2022-12-24', 'YYYY-MM-DD'),
        '10776 King George Boulevard, Surrey, British Columbia',
        'Paws and Claws Animal Shelter'
    );

INSERT INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES 	('C000', 'Smokey', FALSE, 'A very cute cat. Loves to be pet.', 3, 8, 'British  
Shorthair','270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );



INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES 	('C001', 'Pinky', FALSE, 'Not a playful cat.', 3, 20, 'Siamese' , '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES 	('C002', 'Bonbon', TRUE, 'Loves to cuddle and eat.', 3, 15, 'Bengal', '322 Dundas St W, Toronto, Ontario', 'Loving Care Animal Shelter');

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('C003', 'Bambi', FALSE, 'Bambi loves to be pet.', 1, 8, 'Calico', '10776 King George Boulevard, Surrey, British Columbia','Paws and Claws Animal Shelter');

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('C004', 'Daisy', TRUE, 'Loves to eat. Always hungry' , 4, 15, 'Ragdoll', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven' );

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('D000', 'Spots', TRUE, 'A good boy, lots of energy.', 1, 15, 'Dalmatian','270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );


INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('D001', 'Jamie', FALSE, 'Playful dog and loves to cuddle', 5, 20, 'Labrador' , '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES  ('D002', 'Wolfie', FALSE, 'Loves to cuddle.', 3, 15, 'Golden Retriever', '322 Dundas St W, Toronto, Ontario', 'Loving Care Animal Shelter');

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('D003', 'Luna', FALSE, 'Luna loves when you pet her.', 1, 8, 'Chinese Crested Dog', '10776 King George Boulevard, Surrey, British Columbia','Paws and Claws Animal Shelter');


INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('D004', 'Bear', TRUE, 'Loves to eat.' , 1, 3, 'Husky', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven' );

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('B000', 'Coco', FALSE, 'Peaceful bird.', 3, 8, 'Finch','270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );
INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('B001', 'Bluey', FALSE, 'Speaks a lot. So cute.', 5, 20, 'Macaw' , '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('B002', 'Jay', FALSE, 'Loves to speak', 3, 15, 'Parrot', '322 Dundas St W, Toronto, Ontario', 'Loving Care Animal Shelter');

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('B003', 'Raven', FALSE, 'Angry bird', 1, 8, 'Grey parrot' ,'10776 King George Boulevard, Surrey, British Columbia','Paws and Claws Animal Shelter');

INSERT 
INTO RegisteredAnimal (animalID,  name, adopted?, description, age, weight, breed,  shelterLocation, shelterName )
VALUES ('B004', 'Kiwi', FALSE, 'Loves to eat. Always hungry' , 1, 3, 'Dove', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven');


INSERT 
INTO Cats (animalID, hasFur?, social?)   	
VALUES 	('C000', TRUE, TRUE),
		('C001', TRUE, FALSE),
		('C002', TRUE, TRUE),
		('C003', TRUE, TRUE),
		('C004', TRUE, FALSE);


INSERT 
INTO Dogs (animalID, medicallyTrained?, hasFur?)   	
VALUES 	('D000', TRUE, TRUE),
		('D001', FALSE, TRUE),
		('D002', TRUE, TRUE),
		('D003', FALSE, FALSE),
		('D004', FALSE, TRUE);


INSERT 
INTO Birds (animalID, beakSize, wingSpan, color)   	
VALUES 	('B000', 4, 25, ‘White’),
		('B001', 7, 30, ‘Blue’),
		('B002', 9, 20, ‘Green’),
		('B003', 12, 25, ‘Blue’),
		('B004', 5, 12, ‘Grey’);


INSERT
INTO Vaccination (vaccineName, expiryDate, recordID)
VALUES	('Rabies Vaccine', '2045-02-22', 'R123'),
		('Bordetella Vaccine', '2024-02-10', 'R111'),
		('Canine Parvovirus Vaccine', '2030-06-06', 'R222'),
		('Feline Distemper Vaccine', '2034-02-09', 'R333'),
		('Avian Influenza Vaccine', '2029-09-02', 'R444');
		
INSERT
INTO GetVaccination(AnimalID, vaccineName, dateOfVaccination)
VALUES	('C000', 'Rabies Vaccine', '2022-01-20'),
		('D001', 'Bordetella Vaccine', '2021-02-04'),
		('D002', 'Bordetella Vaccine', '2022-09-09'),
		('D002', 'Feline Distemper Vaccine', '2023-02-09'),
		('C002', 'Avian Influenza Vaccine', '2023-09-17');


INSERT
INTO HealthRecord (recordID, allergyInfo, vetID, animalID)
VALUES	('R123', 'Dairy',  Ve11, 'C001'),
		('R111', 'Pollen', Ve12, 'D002'),
		('R222', 'Fish', Ve13, 'C002'),
		('R333', 'Fish', Ve14, 'C003'),
		('R444', 'Chicken', Ve15, 'D004');


 
        