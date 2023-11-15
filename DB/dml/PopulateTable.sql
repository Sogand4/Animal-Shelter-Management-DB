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

INSERT INTO Manager(manID,manPassword) VALUES ('Ali', 'mycat');