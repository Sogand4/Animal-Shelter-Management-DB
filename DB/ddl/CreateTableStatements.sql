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

