CREATE OR REPLACE TRIGGER CheckAdopterConstraint
AFTER INSERT ON AdoptersInfo
FOR EACH ROW
DECLARE
    v_count INTEGER;
BEGIN
    SELECT COUNT(*) INTO v_count FROM Adopt a WHERE a.adopterID = :NEW.adopterID;
    
    IF v_count = 0 THEN
        raise_application_error(-20001, 'All adopters must be participating in an adopt relationship.');
    END IF;
END;