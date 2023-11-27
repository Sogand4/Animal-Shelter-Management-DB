DROP TABLE VolunteersAtShelter;

DROP TABLE Volunteer;

DROP TABLE AvailableDaysRegularVolunteer;

DROP TABLE EventsHosted;

DROP TABLE AdoptersInfo;

DROP TABLE AdoptersLocation;

DROP TABLE Inspect;

DROP TABLE Inspector;

DROP TABLE Manager;

DROP TABLE ManagerPerformance;

DROP TABLE VetWorksAtShelter;

DROP TABLE Cats;

DROP TABLE Dogs;

DROP TABLE Birds;

DROP TABLE GetVaccination;

DROP TABLE Vaccination;

DROP TABLE HealthRecord;

DROP TABLE Vet;

DROP TABLE RegisteredAnimal;

DROP TABLE Shelter;



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
        specialty varchar(255),
        yearsOfExperience INT,
        vetLocation varchar(255),
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

CREATE TABLE VetWorksAtShelter (
    vetID CHAR(4),
    shelterLocation VARCHAR(225),
    shelterName VARCHAR(225),    
    PRIMARY KEY (vetID, shelterLocation, shelterName),
    FOREIGN KEY (vetID) REFERENCES Vet(vetID),
    FOREIGN KEY (shelterName, shelterLocation) REFERENCES Shelter(shelterName, shelterLocation)
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

CREATE TABLE ManagerPerformance (
  kpi VARCHAR(30),
  salary VARCHAR(255),
  PRIMARY KEY (kpi)
);

CREATE TABLE
    Manager(
        manID char(4),
        manPassword char(12),
        shelterLocation VARCHAR(225),
        shelterName VARCHAR(225),
        manName char(30) DEFAULT NULL,
        kpi VARCHAR(30) DEFAULT NULL,
        since date DEFAULT NULL,
        PRIMARY KEY (manID),
        FOREIGN KEY (shelterLocation, shelterName) REFERENCES Shelter(shelterLocation, shelterName),
        FOREIGN KEY (kpi) REFERENCES ManagerPerformance(kpi)
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
        animalID CHAR(4),
        name VARCHAR(225),
        adopted NUMBER(1, 0),
        description VARCHAR(225),
        age INTEGER,
        weight INTEGER,
        breed VARCHAR(225),
        shelterLocation VARCHAR(225) NOT NULL,
        shelterName VARCHAR(225) NOT NULL,
        PRIMARY KEY (animalID),
        FOREIGN KEY (shelterLocation, shelterName) REFERENCES Shelter(shelterLocation, shelterName)
    );

CREATE TABLE
    Cats (
        animalID CHAR(4),
        hasFur NUMBER(1, 0),
        social NUMBER(1, 0),
        PRIMARY KEY(animalID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID) ON DELETE CASCADE
    );

CREATE TABLE
    Dogs (
        animalID CHAR(4),
        medicallyTrained NUMBER(1, 0),
        hasFur NUMBER(1, 0),
        PRIMARY KEY(animalID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID) ON DELETE CASCADE
    );

CREATE TABLE
    Birds (
        animalID CHAR(4),
        beakSize INTEGER,
        wingSpan INTEGER,
        color VARCHAR(225),
        PRIMARY KEY(animalID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID) ON DELETE CASCADE
    );

CREATE TABLE
    HealthRecord (
        recordID char(4) PRIMARY KEY,
        allergyInfo varchar(225),
        vetID char(4) NOT NULL,
        animalID char(4) NOT NULL,
        FOREIGN KEY (vetID) REFERENCES Vet(vetID),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID)
    );

CREATE TABLE Vaccination (
	vaccineName varchar(225) PRIMARY KEY,
	expiryDate date NOT NULL,
	recordID char(4) NOT NULL,
	FOREIGN KEY (recordID) REFERENCES HealthRecord(recordID)
    );


CREATE TABLE
    GetVaccination (
        animalID CHAR(4),
        vaccineName VARCHAR(225),
        dateOfVaccination DATE,
        PRIMARY KEY (animalID, vaccineName),
        FOREIGN KEY (animalID) REFERENCES RegisteredAnimal(animalID),
        FOREIGN KEY (vaccineName) REFERENCES Vaccination(vaccineName)
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



INSERT INTO Vet (vetID, vetName, specialty, yearsOfExperience, vetLocation)
VALUES ('V001', 'Andy White', 'Cardiology', 6, 'Surrey');

INSERT INTO Vet (vetID, vetName, specialty, yearsOfExperience, vetLocation)
VALUES ('V002', 'Jack Allen', 'Cardiology', 4, 'Surrey');

INSERT INTO Vet (vetID, vetName, specialty, yearsOfExperience, vetLocation)
VALUES ('V003', 'Jackie Brown', 'Neurology', 3, 'Surrey');

INSERT INTO Vet (vetID, vetName, specialty, yearsOfExperience, vetLocation)
VALUES ('V004', 'Mary Moore', 'Oncology', 2, 'San Francisco');

INSERT INTO Vet (vetID, vetName, specialty, yearsOfExperience, vetLocation)
VALUES ('V005', 'Sandy Blum', 'Dentistry', 8, 'Dentistry');


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

INSERT INTO VetWorksAtShelter (vetID, shelterLocation, shelterName)
VALUES ('V001', '10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter');

INSERT INTO VetWorksAtShelter (vetID, shelterLocation, shelterName)
VALUES ('V002', '10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter');

INSERT INTO VetWorksAtShelter (vetID, shelterLocation, shelterName)
VALUES ('V003', '10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter');

INSERT INTO VetWorksAtShelter (vetID, shelterLocation, shelterName)
VALUES ('V004', '234 Willow Lane, Supportville, USA', 'The Animal Haven');

INSERT INTO VetWorksAtShelter (vetID, shelterLocation, shelterName)
VALUES ('V005', '234 Willow Lane, Supportville, USA', 'The Animal Haven');

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



INSERT INTO ManagerPerformance (kpi, salary) VALUES ('AnimalAdoptionRate : 70%', '5000/month');
INSERT INTO ManagerPerformance (kpi, salary) VALUES ('AnimalAdoptionRate : 75%', '5500/month');
INSERT INTO ManagerPerformance (kpi, salary) VALUES ('AnimalAdoptionRate : 60%', '4000/month');
INSERT INTO ManagerPerformance (kpi, salary) VALUES ('AnimalAdoptionRate : 50%', '4000/month');
INSERT INTO ManagerPerformance (kpi, salary) VALUES ('AnimalAdoptionRate : 80%', '6000/month');




INSERT INTO Manager(manID, manPassword, shelterLocation, shelterName) VALUES ('M001', 'myt', '234 Willow Lane, Supportville, USA' , 'The Animal Haven');

INSERT INTO Manager(manID, manPassword, shelterLocation, shelterName) VALUES ('M002', 'myt','234 Willow Lane, Supportville, USA' , 'The Animal Haven');

INSERT INTO Manager (manID, manPassword, shelterLocation, shelterName) VALUES ('M003', 'pass','234 Willow Lane, Supportville, USA' , 'The Animal Haven');

INSERT INTO Manager(manID, manPassword, shelterLocation, shelterName) VALUES ('M004', 'pass4','10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter');

INSERT INTO Manager (manID, manPassword, shelterLocation, shelterName) VALUES ('M005', 'pass5','10776 King George Boulevard, Surrey, British Columbia', 'Paws and Claws Animal Shelter');


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
        'Pets 101',
        'Time to learn about being a pet owner',
        '$15 per person',
        TO_DATE('2023-12-24', 'YYYY-MM-DD'),
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
        'Sick pet caring',
        'Caring ways for your sick pet',
        '$10 per person',
        TO_DATE('2023-11-12', 'YYYY-MM-DD'),
        '234 Willow Lane, Supportville, USA', 
        'The Animal Haven'
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
        'Vets 101',
        'Which vets can you trust?',
        '$11 per person',
        TO_DATE('2023-12-06', 'YYYY-MM-DD'),
        '234 Willow Lane, Supportville, USA', 
        'The Animal Haven'
    );



INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES 	('C000', 'Smokey', 0, 'A very cute cat. Loves to be pet.', 3, 8, 'British Shorthair','270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home' );

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES 	('C001', 'Pinky', 0, 'Not a playful cat.', 3, 20, 'Siamese' , '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES 	('C002', 'Bonbon', 1, 'Loves to cuddle and eat.', 3, 15, 'Bengal', '322 Dundas St W, Toronto,Ontario', 'Loving Care Animal Shelter');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('C003', 'Bambi', 0, 'Bambi loves to be pet.', 1, 8, 'Calico', '10776 King George Boulevard, Surrey, British Columbia','Paws and Claws Animal Shelter');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('C004', 'Daisy', 1, 'Loves to eat. Always hungry' , 4, 15, 'Ragdoll', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('D000', 'Spots', 1, 'A good boy, lots of energy.', 1, 15, 'Dalmatian','270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('D001', 'Jamie', 0, 'Playful dog and loves to cuddle', 5, 20, 'Labrador' , '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES  ('D002', 'Wolfie', 0, 'Loves to cuddle.', 3, 15, 'Golden Retriever', '322 Dundas St W, Toronto,Ontario', 'Loving Care Animal Shelter');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('D003', 'Luna', 0, 'Luna loves when you pet her.', 1, 8, 'Chinese Crested Dog', '10776 King George Boulevard, Surrey, British Columbia','Paws and Claws Animal Shelter');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('D004', 'Bear', 1, 'Loves to eat.' , 1, 3, 'Husky', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('B000', 'Coco', 1, 'Peaceful bird.', 3, 8, 'Finch','270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('B001', 'Bluey', 1, 'Speaks a lot. So cute.', 5, 20, 'Macaw' , '270 Gerrard St E, Toronto, Ontario', 'Lovely Pet Home');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('B002', 'Jay', 0, 'Loves to speak', 3, 15, 'Parrot', '322 Dundas St W, Toronto,Ontario', 'Loving Care Animal Shelter');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('B003', 'Raven', 0, 'Angry bird', 1, 8, 'Grey parrot' ,'10776 King George Boulevard, Surrey, British Columbia','Paws and Claws Animal Shelter');

INSERT INTO RegisteredAnimal (animalID,  name, adopted, description, age, weight, breed,  shelterLocation, shelterName)
VALUES ('B004', 'Kiwi', 0, 'Loves to eat. Always hungry' , 1, 3, 'Dove', '4455 110 Avenue SE, Calgary, Alberta', 'The Animal Haven');

INSERT INTO Cats (animalID, hasFur, social) VALUES ('C000', 1, 1);
INSERT INTO Cats (animalID, hasFur, social) VALUES ('C001', 1, 0);
INSERT INTO Cats (animalID, hasFur, social) VALUES ('C002', 1, 1);
INSERT INTO Cats (animalID, hasFur, social) VALUES ('C003', 1, 1);
INSERT INTO Cats (animalID, hasFur, social) VALUES ('C004', 1, 0);

INSERT INTO Dogs (animalID, medicallyTrained, hasFur) VALUES ('D000', 1, 1);
INSERT INTO Dogs (animalID, medicallyTrained, hasFur) VALUES ('D001', 0, 1);
INSERT INTO Dogs (animalID, medicallyTrained, hasFur) VALUES ('D002', 1, 1);
INSERT INTO Dogs (animalID, medicallyTrained, hasFur) VALUES ('D003', 0, 0);
INSERT INTO Dogs (animalID, medicallyTrained, hasFur) VALUES ('D004', 0, 1);

INSERT INTO Birds (animalID, beakSize, wingSpan, color) VALUES ('B000', 4, 25, 'White');
INSERT INTO Birds (animalID, beakSize, wingSpan, color) VALUES ('B001', 7, 30, 'Blue');
INSERT INTO Birds (animalID, beakSize, wingSpan, color) VALUES ('B002', 9, 20, 'Green');
INSERT INTO Birds (animalID, beakSize, wingSpan, color) VALUES ('B003', 12, 25, 'Blue');
INSERT INTO Birds (animalID, beakSize, wingSpan, color) VALUES ('B004', 5, 12, 'Grey');

INSERT INTO HealthRecord (recordID, allergyInfo, vetID, animalID) VALUES ('R123', 'Dairy',  'V001', 'C001');
INSERT INTO HealthRecord (recordID, allergyInfo, vetID, animalID) VALUES ('R111', 'Pollen', 'V001', 'D002');
INSERT INTO HealthRecord (recordID, allergyInfo, vetID, animalID) VALUES ('R222', 'Fish', 'V002', 'C002');
INSERT INTO HealthRecord (recordID, allergyInfo, vetID, animalID) VALUES ('R333', 'Fish', 'V004', 'C003');
INSERT INTO HealthRecord (recordID, allergyInfo, vetID, animalID) VALUES ('R444', 'Chicken', 'V005', 'D004');

INSERT INTO Vaccination (vaccineName, expiryDate, recordID) VALUES ('Rabies Vaccine', TO_DATE('2045-02-22', 'YYYY-MM-DD'), 'R123');
INSERT INTO Vaccination (vaccineName, expiryDate, recordID) VALUES ('Bordetella Vaccine', TO_DATE('2024-02-10', 'YYYY-MM-DD'), 'R111');
INSERT INTO Vaccination (vaccineName, expiryDate, recordID) VALUES ('Canine Parvovirus Vaccine', TO_DATE('2030-06-06', 'YYYY-MM-DD'), 'R222');
INSERT INTO Vaccination (vaccineName, expiryDate, recordID) VALUES ('Feline Distemper Vaccine', TO_DATE('2034-02-09', 'YYYY-MM-DD'), 'R333');
INSERT INTO Vaccination (vaccineName, expiryDate, recordID) VALUES ('Avian Influenza Vaccine', TO_DATE('2029-09-02', 'YYYY-MM-DD'), 'R444');
		
INSERT INTO GetVaccination(AnimalID, vaccineName, dateOfVaccination) VALUES	('C000', 'Rabies Vaccine', TO_DATE('2022-01-20', 'YYYY-MM-DD'));
INSERT INTO GetVaccination(AnimalID, vaccineName, dateOfVaccination) VALUES	('D001', 'Bordetella Vaccine', TO_DATE('2021-02-04', 'YYYY-MM-DD'));
INSERT INTO GetVaccination(AnimalID, vaccineName, dateOfVaccination) VALUES	('D002', 'Bordetella Vaccine', TO_DATE('2022-09-09', 'YYYY-MM-DD'));
INSERT INTO GetVaccination(AnimalID, vaccineName, dateOfVaccination) VALUES	('D002', 'Feline Distemper Vaccine', TO_DATE('2023-02-09', 'YYYY-MM-DD'));
INSERT INTO GetVaccination(AnimalID, vaccineName, dateOfVaccination) VALUES	('C002', 'Avian Influenza Vaccine', TO_DATE('2023-09-17', 'YYYY-MM-DD'));


 
        