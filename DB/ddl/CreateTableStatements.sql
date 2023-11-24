CREATE TABLE AvailableDaysRegularVolunteer(
    availableDays char(7) PRIMARY KEY,
    regularVolunteer NUMBER(1, 0) NOT NULL
);

CREATE TABLE Volunteer (
    volunteerID char(4) PRIMARY KEY,
    name varchar(255) NOT NULL,
    availableDays char(7),
    phoneNumber int,
    FOREIGN KEY (availableDays) REFERENCES AvailableDaysRegularVolunteer(availableDays)
);

CREATE TABLE Inspector(
    insName VARCHAR(225) NOT NULL,
    insID CHAR(4),
    PRIMARY KEY (insID)
);

CREATE TABLE Vet(
    vetID CHAR(4),
    vetName VARCHAR(225) NOT NULL,
    PRIMARY KEY (vetID)
);

CREATE TABLE AdoptersLocation(
    postalCode VARCHAR(225),
    city VARCHAR(225),
    streetName VARCHAR(225),
    province VARCHAR(225),
    PRIMARY KEY (postalCode)
);

CREATE TABLE AdoptersInfo(
    adopterID CHAR(4),
    nationalID CHAR(10) UNIQUE,
    name VARCHAR(225),
    phoneNumber INT,
    email VARCHAR(225) UNIQUE,
    postalCode VARCHAR(225),
    houseNumber VARCHAR(225),
    PRIMARY KEY (adopterID),
    FOREIGN KEY (postalCode) REFERENCES AdoptersLocation(postalCode)
        ON DELETE SET NULL
);

CREATE TABLE Shelter(
  shelterLocation VARCHAR(225),
  capacity INT,
  shelterName VARCHAR(225),
  PRIMARY KEY (shelterLocation,shelterName)
);

CREATE TABLE Inspect(
  insID CHAR(4),
  shelterLocation VARCHAR(225),
  shelterName VARCHAR(225),
  standardsMet NUMBER(1, 0),
  PRIMARY KEY (insID, shelterLocation, shelterName),
  FOREIGN KEY (insID) REFERENCES Inspector(insID),
  FOREIGN KEY (shelterLocation,shelterName) REFERENCES
  Shelter(shelterLocation,shelterName)
);

CREATE TABLE Manager(
    manID char(4),
    manPassword char(12),
    manName char(30) DEFAULT NULL,
    kpi char(30) DEFAULT NULL,
    PRIMARY KEY (manID)
);

CREATE TABLE VolunteersAtShelter(
	volunteerID char(4),
	shelterLocation varchar(225),
	shelterName varchar(225),
    since date,
    PRIMARY KEY (volunteerID, shelterLocation, shelterName),
    FOREIGN KEY (volunteerID) REFERENCES Volunteer(volunteerID),
    FOREIGN KEY (shelterName, shelterLocation) REFERENCES
    Shelter(shelterName, shelterLocation)
);
